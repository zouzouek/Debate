<?php

include '../config/db.php';
session_start();
if (!isset($_GET['t']) || !isset($_GET['name']))
    header("Location: ../alert/error.php");

$tag = $_GET['name'];
$parts = explode('_', $tag);
$side1 = $parts[0];
$side2 = $parts[1];

$tid = $_GET['t'];
$result = array();
$x_values = array();
$y1_values = array();
$y2_values = array();

$stats_query = mysql_query("SELECT UNIX_TIMESTAMP(Date) AS UNIX, Date, M, D, H,
    SUM(side = 1) AS side1,
    SUM(side = 2) AS side2
FROM (
    SELECT side, Date, MONTH(Date) as M, DAY(Date) as D, HOUR(Date) as H
    FROM `comments_table`
    WHERE YEAR(Date) = '2014' AND `tid` = '$tid' AND `reports` < 1
) t
GROUP BY M,D,H
ORDER BY UNIX");

while ($stats = mysql_fetch_array($stats_query)) {
    $time = $stats['UNIX'];
    //$date = date('d', strtotime($stats['Date']));

  // if ((int) $stats['side1'] != 0 && (int) $stats['side2'] != 0) {
        array_push($x_values, (int) $time);
        array_push($y1_values, (int) $stats['side1']);
        array_push($y2_values, (int) $stats['side2']);
        $result[] = array('date' => (int) $time, 'y' => (int) $stats['side1'], 'group' => $side1);
        $result[] = array('date' => (int) $time, 'y' => (int) $stats['side2'], 'group' => $side2);
   // }
}

mysql_close();

$r = findLineByLeastSquares($x_values, $y1_values);
$s = findLineByLeastSquares($x_values, $y2_values);

for ($v = 0; $v < count($r[0]); $v++) {
    if ($v == 0) {
        $line1StartX = $r[0][$v];
        $line1StartY = $r[1][$v];
        $line2StartX = $s[0][$v];
        $line2StartY = $s[1][$v];
    }
    if ($v == count($r[0]) - 1) {
        $line1EndX = $r[0][$v];
        $line1EndY = $r[1][$v];
        $line2EndX = $s[0][$v];
        $line2EndY = $s[1][$v];

        $intersect = checkLineIntersection($line1StartX, $line1StartY, $line1EndX, $line1EndY, $line2StartX, $line2StartY, $line2EndX, $line2EndY);
        $comment = CommentOnResult($intersect, $r[2][0], $r[2][1], $s[2][0], $s[2][1], $side1, $side2);
        $result[] = array('date' => $r[0][$v], 'ry' => $r[1][$v], 'group' => $side1);
        $result[] = array('date' => $s[0][$v], 'ry' => $s[1][$v], 'comment' => $comment, 'group' => $side2);
    } else {
        $result[] = array('date' => $r[0][$v], 'ry' => $r[1][$v], 'group' => $side1);
        $result[] = array('date' => $s[0][$v], 'ry' => $s[1][$v], 'group' => $side2);
    }
}

echo json_encode($result);

function findLineByLeastSquares($values_x, $values_y) {
    $sum_x = 0;
    $sum_y = 0;
    $sum_xy = 0;
    $sum_xx = 0;
    $count = 0;

    /*
     * We'll use those variables for faster read/write access.
     */
    $x = 0;
    $y = 0;
    $values_length = count($values_x);
    if ($values_length != count($values_y)) {
        die('The parameters values_x and values_y need to have same size!');
    }

    /*
     * Nothing to do.
     */
    if ($values_length === 0) {
        return [[], []];
    }

    /*
     * Calculate the sum for each of the parts necessary.
     */
    for ($v = 0; $v < $values_length; $v++) {
        $x = $values_x[$v];
        $y = $values_y[$v];
        $sum_x += $x;
        $sum_y += $y;
        $sum_xx += $x * $x;
        $sum_xy += $x * $y;
        $count++;
    }

    /*
     * Calculate m and b for the formular:
     * y = x * m + b
     */
    $m = ($count * $sum_xy - $sum_x * $sum_y) / ($count * $sum_xx - $sum_x * $sum_x);
    $b = ($sum_y / $count) - ($m * $sum_x) / $count;
    //echo "$m-------$b\n";
    $eq = array();
    array_push($eq, $m);
    array_push($eq, $b);
    /*
     * We will make the x and y result line now
     */
    $result_values_x = array();
    $result_values_y = array();

    for ($v = 0; $v < $values_length; $v++) {
        $x = $values_x[$v];
        $y = $x * $m + $b;
        array_push($result_values_x, $x);
        array_push($result_values_y, $y);
    }

    return [$result_values_x, $result_values_y, $eq];
}

function checkLineIntersection($line1StartX, $line1StartY, $line1EndX, $line1EndY, $line2StartX, $line2StartY, $line2EndX, $line2EndY) {
    // if the lines intersect, the result contains the x and y of the intersection (treating the lines as infinite) and booleans for whether line segment 1 or line segment 2 contain the point

    $result = array();
    $denominator = (($line2EndY - $line2StartY) * ($line1EndX - $line1StartX)) - (($line2EndX - $line2StartX) * ($line1EndY - $line1StartY));
    if ($denominator == 0) {
        return $result;
    }
    $a = $line1StartY - $line2StartY;
    $b = $line1StartX - $line2StartX;
    $numerator1 = (($line2EndX - $line2StartX) * $a) - (($line2EndY - $line2StartY) * $b);
    $numerator2 = (($line1EndX - $line1StartX) * $a) - (($line1EndY - $line1StartY) * $b);
    $a = $numerator1 / $denominator;
    $b = $numerator2 / $denominator;

    // if we cast these lines infinitely in both directions, they intersect here:
    $result['x'] = ($line1StartX + ($a * ($line1EndX - $line1StartX)));
    $result['y'] = ($line1StartY + ($a * ($line1EndY - $line1StartY)));

    /*
      // it is worth noting that this should be the same as:
      x = line2StartX + (b * (line2EndX - line2StartX));
      y = line2StartX + (b * (line2EndY - line2StartY));
     */
    // if line1 is a segment and line2 is infinite, they intersect if:
    if ($a > 0 && $a < 1) {
        $result['on1'] = true;
    } else {
        $result['on1'] = false;
    }
    // if line2 is a segment and line1 is infinite, they intersect if:
    if ($b > 0 && $b < 1) {
        $result['on2'] = true;
    } else {
        $result['on2'] = false;
    }
    //echo json_encode($result);
    // if line1 and line2 are segments, they intersect if both of the above are true
    return $result;
}

function CommentOnResult($intersect, $m1, $b1, $m2, $b2, $side1, $side2) {
    $comment = "";
    if ($m1 < 0) {
        $comment .= " $side1's side activity is decreasing.";
    } elseif ($m1 > 0) {
        $comment .= " $side1's side activity is increasing.";
    } else {
        $comment .= " $side1's side activity is non-changing.";
    }
    if ($m2 < 0) {
        $comment .= " $side2's side activity is decreasing.";
    } elseif ($m2 > 0) {
        $comment .= " $side2's side activity is increasing.";
    } else {
        $comment .= " $side2's side activity is non-changing.";
    }


    if ($intersect['on1'] == 1 && $intersect['on2'] == 1) {
        $time = $intersect['x'];
        $time = gmdate("Y-M-d > H:i:s <", $time);
        $comment .= " Lines intersect at time = $time";
        if ($m1 > $m2) {
            $comment .= " and $side1 has shown better results on this date onwards.";
        } elseif ($m1 < $m2) {
            $comment .= " and $side2 has shown better results on this date onwards.";
        } else {
            if ($b1 == $b2) {
                $comment .= " and both sides have the exact level of activity.";
            } else {
                $comment .= " and the results are parallel to one another.";
            }
        }
    } else {
        $comment .= ". The two lines never meet.";
        if ($m1 == $m2 && $b1 != $b2) {
            $comment .= " Results are parallel to one another.";
        }
    }

    // echo $comment;
    return $comment;
}

?>
