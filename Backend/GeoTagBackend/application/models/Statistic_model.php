<?php

/**
 * @author Milos Matijasevic 0440/15
 * @author Jakov Jezdic 0043/15
 * Statistic_model - handles all database manipulation regarding statistics
 */
class Statistic_model extends CI_Model{
    
    // update statistic table, on given field in given direction
    // @param string $field Field in table statistic to be updated, string $dir How much it should be increased/decreased (default ++)
    // @return void
    public function updateStatistics($field, $dir = "+1") {
        date_default_timezone_set("Europe/Belgrade");
        $now = new DateTime();
        $date=$now->format('Y-m-d');

        $this->db->where('date', $date);
        $this->db->from('statistic');

        if ($this->db->count_all_results() > 0) {
            $this->db->set($field, $field.$dir, FALSE);
            $this->db->where('date', $date);
            $this->db->update('statistic');
        }
        else {
            $newrow['date']=$date;
            $newrow['userCount']=0;
            $newrow['reviewCount']=0;
            $newrow['destinationCount']=0;
            $newrow['positiveVoteCount']=0;
            $newrow['negativeVoteCount']=0;

            $newrow[$field] = 1;
            $this->db->insert('statistic', $newrow);
        }
    }
    
    // get statistics data
    // @return array Array containing all needed fields 
    public function getStatistics(){
        
        date_default_timezone_set("Europe/Belgrade");
        $now = new DateTime();
        $date=$now->format('Y-m-d');
    
        $rows = $this->db->get('statistic')->result();
        
        $row=null;
               
        foreach ($rows as $r){
            if (date('j', strtotime($date))==date('j', strtotime($r->date)) &&  //DAY
                date('n', strtotime($date))==date('n', strtotime($r->date)) &&  //MONTH
                date('Y', strtotime($date))==date('Y', strtotime($r->date)) ){  //YEAR
                
                $row=$r;
                break;
            }
        }
        
        if ($row==null){                                //for every day making new row in table
            $newrow['date']=$date;
            $newrow['userCount']=0;
            $newrow['reviewCount']=0;
            $newrow['destinationCount']=0;
            $newrow['positiveVoteCount']=0;
            $newrow['negativeVoteCount']=0;
            
            $this->db->insert('statistic', $newrow);
            
            $retrow= new \stdClass();
            $retrow->date=$newrow['date'];
            $retrow->userCount=$newrow['userCount'];       //to be consistently as return value
            $retrow->reviewCount=$newrow['reviewCount'];
            $retrow->destinationCount=$newrow['destinationCount'];
            $retrow->positiveVoteCount=$newrow['positiveVoteCount'];
            
            $row=$retrow;
        }
        
       
        
        $row->day=$row->date;
        
        foreach ($rows as $r ){//searching rows for last 7 days
            
            $interval = date_diff(date_create($row->date),date_create($r->date),true);
            
            $diff=(int)($interval->format("%d"));            // diffrence in days

            
            if ($diff<7 && $r->date != $row->date){
                $row->userCount=$row->userCount+$r->userCount;
                $row->reviewCount=$row->reviewCount+$r->reviewCount;            //if row is in last 7 days add
                $row->destinationCount=$row->destinationCount+$r->destinationCount;
                $row->positiveVoteCount=$row->positiveVoteCount+$r->positiveVoteCount;
                
            }
            
        }
        
        $reviews=$this->db->get('review')->result();
        
        $row->posReviews=0;
        foreach ($reviews as $rev){                             //loop for sum of reviews in last 7 days
            $interval = date_diff(date_create($row->date),date_create($rev->date),true);
            
            $diff=(int)($interval->format("%d"));           
                
            if ($diff<7){
                if ($rev->upCount>$rev->downCount)
                    $row->posReviews++;
            }
            
        }
        return $row;
    }

}
