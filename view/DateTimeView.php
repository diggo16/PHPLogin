<?php

class DateTimeView {

        /*
         * Create a string of the date and time
         */
	public function show() {
            date_default_timezone_set("Europe/Berlin");
            $day = date("l");       // Day in the week in letters
            $number = date("jS");   // The day in number with "st" after
            $month = date("F");     // Month in letters
            $year = date("Y");      // Year in letters
            $time = date("h:i:s");  // The time
            
            $hours = intval(date("h"));
            $minutes = date("i");
            $seconds = date("s");
            $midday = date("A");
            // If it is PM, add 12 hours to get digital time
            if($midday == "PM")
            {
                $hours += 12; 
            }
            // add the time to the same variable
            $time = $hours.":".$minutes.":".$seconds;
            
            $timeString = $day.", the ".$number." of ".$month." ".$year.
                        ", The time is ".$time;
            return '<p>' . $timeString . '</p>';   
	}
}