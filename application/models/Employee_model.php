<?php
class Employee_model extends CI_Model
{
        public $i;

        public function insert_record()
        {
            $people_array    = $this->input->post('people');
            
            $array_element_count = count($people_array);
            
            for($i=1; $i<=$array_element_count; $i++)
            {
                ##### Fetch individual array field element values from parent array #####
                $firstname = $people_array[$i]['firstname'];
                $lastname = $people_array[$i]['lastname'];
                $email = $people_array[$i]['email'];
                $job_role = $people_array[$i]['job_role'];
                @$reference_empid = @$people_array[$i]['referenceid'];

                ##### Check if all entered values are not empty #####
                if(!empty($firstname)&&(!empty($lastname))&&(!empty($email))&&(!empty($job_role)))
                {
                        ##### Check if more already 4 records exist for this job role in database #####
                        $this->db->select('*');
                        $this->db->from('employeelist');
                        $this->db->where('emp_job_role', $job_role);
                        $job_result_search = $this->db->get();
                        $job_count = $job_result_search->num_rows();

                        if($job_count<4)
                        {
                            ##### Check if empid ( unique id of db already exists), if yes to update that record & not add another row #####
                            if(($reference_empid)&&($reference_empid!=''))
                            {
                                $updatearray = array(
                                    'emp_first_name'=>$firstname,
                                    'emp_last_name'=>$lastname,
                                    'emp_email'=>$email,
                                    'emp_job_role'=>$job_role
                                );
                                $updatetable = 'employeelist';

                                $this->db->where('empID', $reference_empid);
                                $this->db->update($updatetable, $updatearray);
                            }
                            else
                            {
                                ##### Add data into database #####
                                $insertarray = array(
                                        'emp_first_name'=>$firstname,
                                        'emp_last_name'=>$lastname,
                                        'emp_email'=>$email,
                                        'emp_job_role'=>$job_role
                                );
                                $inserttable = 'employeelist';

                                $this->db->insert($inserttable, $insertarray);
                                $this->session->set_flashdata('display_user_message', 'Record added successfully.');
                            }
                        }
                        else
                        {
                            $this->session->set_flashdata('display_user_message', 'Some records could not be added because max entries for each job role can be 4');
                            continue;
                        }
                }
                else
                {
                        continue;
                }
            }
        }
        public function select_records()
        {
            $queryResult = $this->db->query('SELECT * from employeelist');
            $countResults = $queryResult->num_rows();

            if($countResults>'0')
            {
                $return_array['count'] = $countResults; 
                $return_array['list'] = $queryResult->result_array();
            }
            else
            {
                $return_array['count'] = '0';
            }
            return $return_array;
        }
        public function delete_records($data)
        {
            $employee_delete_id = $data['empid'];
            $table_name = "employeelist";

            $this->db->where('empID',$employee_delete_id);
            $this->db->delete($table_name); 

            $this->session->set_flashdata('display_user_message', 'Record deleted successfully.');
        }
}
?>