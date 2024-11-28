<?php



require_once($CFG->libdir . '/completionlib.php');







function block_my_homecourses() {

    global $DB, $USER, $OUTPUT, $CFG; 

    /*require_once($CFG->dirroot . '/user/lib.php');

    $PAGE->page->requires->js_call_amd('block_homecourse/script', 'init');*/

  

     $html = '';

     $html .= html_writer::start_tag('ul', array('id' => 'course_list_in_block'));

//cursos
     $categorias = $DB->get_records_sql("SELECT cat.* from {role_assignments} as ra
        join {context} as c on c.id = ra.contextid
         join {course} as cc on cc.id = c.instanceid
        join {course_categories} as cat on cat.id = cc.category
        where ra.userid = ".$USER->id." and cc.visible = 1 group by cat.id ");

      

    $html .= '<div class="homecourse">';

    foreach($categorias as $cats){ 
        $cursoscarreira = $DB->get_records_sql("SELECT cc.* from {role_assignments} as ra
        join {context} as c on c.id = ra.contextid
         join {course} as cc on cc.id = c.instanceid 
        where ra.userid = ".$USER->id." and cc.visible = 1 and cc.category = ".$cats->id." order by cc.sortorder ");
       
 
        $html .= '<h4>'.$cats->name.'<h4>'; 
                $html .= ' 
                   <section class="splide" aria-label="">
                      <div class="splide__track">
                        <ul class="splide__list"> ';
                   $mycourses = "";
                foreach ($cursoscarreira as $cursocarreira) {

                    $url = new moodle_url($CFG->wwwroot . '/course/view.php', array('id' => $cursocarreira->id));

                    $anchor = $cursocarreira->fullname; 
                    $mycourses .= $cursocarreira->id.',';
                    $html .= '<div class="item splide__slide">   <a class="homebg" href="'.$url.'"> ' ;

                    $contexts = $DB->get_field_select('context', 'id', 'contextlevel = 50 AND instanceid = '.$cursocarreira->id.' ');
 

                    $sqlimg = "SELECT * from mdl_files where filearea = 'overviewfiles' AND component = 'course' AND filesize > 0 AND contextid = :context";

                    $imagem = $DB->get_records_sql($sqlimg, array('context'=>$contexts));

                    if(empty($imagem)){

                        $html .= '<span class="imagem-curso"><img src="'.$CFG->wwwroot.'/blocks/homecourse/default.jpg" /></span>';

                    }else{                                                

                        foreach($imagem as $img){ 

                             $bg = ''.$CFG->wwwroot.'/pluginfile.php/'.$img->contextid.'/course/overviewfiles/'.$img->source.'';

                             $html .= '<span class="imagem-curso"><img src="'.$bg.'" /></span>';  

                        }

                    }

                    $count = $DB->get_field_sql('SELECT COUNT(id) as "atividades" from mdl_course_modules where course = :course', array('course'=>$cursocarreira->id));
                    
                    $html .= '<div class="curso-container">';
                    
                    $html .= '<h4>'.$anchor.'</h4>'; 

                     $sql_totalprogress = 'SELECT COUNT(cm.completion) AS countprogressactivity FROM mdl_role_assignments rs INNER JOIN mdl_context e ON rs.contextid=e.id INNER JOIN mdl_course c ON c.id=e.instanceid INNER JOIN mdl_course_modules cm ON cm.course=c.id WHERE e.contextlevel=50 

                AND rs.userid= :userid AND c.id = :courseid AND cm.completion > 0 ';

                $count_totalprogress = $DB->get_field_sql($sql_totalprogress,['userid'=>$USER->id, 'courseid'=>$cursocarreira->id]); 

              

                  

                $sql_userprogress = 'SELECT COUNT(cmp.completionstate) AS countrecord FROM mdl_course_modules_completion cmp INNER JOIN mdl_course_modules cm ON cmp.coursemoduleid = cm.id 

                WHERE cmp.userid= :userid AND cm.course = :courseid AND cm.completion > 0 AND cmp.completionstate > 0  AND cmp.completionstate < 3';

                $count_userprogress = $DB->get_field_sql($sql_userprogress,['userid'=>$USER->id, 'courseid'=>$cursocarreira->id]); 

          

                 
                if($count_totalprogress > 0){
                    $countprogress = $count_userprogress*100/$count_totalprogress;

                    if($countprogress > 0){  

                    $progress = round($countprogress).'% completo';

                    }else{

                    $progress = 'Ainda não iniciado';

                    }
                    
                }
                
                    $html .= '<span class="progress"><span class="completed" style="width: '.$countprogress.'%;"></span></span>';

                    $html .= '<h6 class="text">'.$progress.'</h6>'; 

                    $html .= '<span class="bot"> ';
 
                    $html .= ' </span></div>';

                    $html .= '</a> </div>';



                        

                     

                }

                $html .= '</ul>
                          </div>
                        </section> ';

          
        }
          //acabar categorias

    $html .= '</div>';


 

















    //end

    $html .= html_writer::end_tag('ul');

    return $html;

    

   

}

 



?>