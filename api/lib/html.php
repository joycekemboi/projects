
<?php
	# ERROR DISPLAY 
	function gams_er ( $level, $alert ) {
	if ( $alert == ''  ) {
		return;
	}
	
	else {
		// check alert type 
		switch ( $level ) {
			case 'error':
			return '<div class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert">
							<i class="fa fa-remove"></i>
						</button>

						<strong>
							<i class="fa fa-remove"></i>							
						</strong>
						'.$alert.'
						<br />
					</div>';
			break;
			
			case 'success':			
			return '<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert">
							<i class="fa fa-remove"></i>
						</button>

						<strong>
							<i class="fa fa-thumbs-o-up"></i>							
						</strong>
						'.$alert.'
						<br />
					</div>';
			break;
			
			case 'warning':
			
			return '<div class="alert alert-warning">
						<button type="button" class="close" data-dismiss="alert">
							<i class="fa fa-remove"></i>
						</button>

						<strong>
							<i class="fa fa-exclamation-triangle"></i>							
						</strong>
						'.$alert.'
						<br />
					</div>';
			break;
			
			case 'notice':
			
			return '<div class="alert alert-info">
						<button type="button" class="close" data-dismiss="alert">
							<i class="fa fa-remove"></i>
						</button>

						<strong>
							<i class="fa fa-info"></i>							
						</strong>
						'.$alert.'
						<br />
					</div>';
			break;
		}
	}
		

	}	
	
	
	
	  function sms_form($label,$id_name,$value)
        {
            return 
            "
                <div class='form-group'>
                    <label  class='col-lg-3 control-label'>".$label."</label>
                    <div class='col-lg-6'>
                        <input type='text' class='form-control' id='".$id_name."' name='".$id_name."' placeholder='' value = ".$value.">
                    </div>
                </div>
            "
            
            ;
        }
        
        function begin_form($method,$action,$identity=array())
        {
            $id = $identity['id'];
            $class = $identity['class'];           
            return "<form action = '".$action."' method = '".$method."' id = '".$id."' class='".$class."' >";
            
        }
        
        function end_form()
        {
            return "</form>";
        }
        
        //dynamic dropdown
        function sms_dropdown($id,$name,$value,$option_name,$select_string,$table,$condition=array())
        {
            
            echo "<select id = '".$id."' name = '".$name."' class = 'form-control' >";
            if(!empty($select_string))
            {
                echo "<option value = '' selected='selected'>".$select_string."</option>";
            }
            
            $selec_data = '';
           
            
            if(!empty($table))
            {
                if(!empty($condition))
                {
                                        
                    $selec_data  = select_data($table, $condition);
                }
                else
                {
                   $selec_data = findall($table); 
                }
                
                foreach ($selec_data as $data)
                {
                    echo "<option value='".$data[$value]."'>".ucfirst($data[$option_name])."</option>";
                    
                }
            }            
            else
            {
                echo  "<option value='".$value."'>".$option_name."</option>";
            }
            
            
            echo "</select>";
            
            
        }
 ?>