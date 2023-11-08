<?php


foreach ($rec as $records) {
    $day = $records->days;
    $daysid = $records->id;
    $day_records = array();

    $rec2 = $DB->get_records_sql("SELECT * FROM {new_timetable} WHERE days_id = $daysid AND t_teacher = $t_teacher");

    foreach ($rec2 as $records1) {
        // Retrieve record values for each iteration
        $period_id = $records1->period_id;
        $id = $records1->id;
        $from_time = $records1->from_time;
        $to_time = $records1->to_time;
        $subject = $records1->t_subject;
        $sub_name = $DB->get_record_sql("SELECT * FROM {subject} WHERE id = $subject");
        $t_subject = $sub_name->sub_name;
        $value1 = $DB->get_record_sql("SELECT * FROM {new_timetable_periods} WHERE id = $period_id");
        $class = $value1->t_class;
        $class_name = $DB->get_record_sql("SELECT * FROM {class} WHERE id = $class");
        $t_class = $class_name->class_name;
        $division = $value1->t_division;
        $div_name = $DB->get_record_sql("SELECT * FROM {division} WHERE id = $division");
        $t_division = $div_name->div_name;
        $break_type = $records1->break_type;
        $break_ftime = $records1->break_ftime;
        $break_ttime = $records1->break_ttime;
        $days_id = $records1->days_id;

        $day_records[] = array(
            'id' => $id,
            'from_time' => $from_time,
            'to_time' => $to_time,
            't_subject' => $t_subject,
            't_class' => $t_class,
            't_division' => $t_division,
            'break_type' => $break_type,
            'break_ftime' => $break_ftime,
            'break_ttime' => $break_ttime
        );
    }

    $period_records = array('period_id' => $daysid);

    $data[] = array(
        'days' => $day,
        'records' => $day_records,
        'periods' => $period_records
    );
}


?>