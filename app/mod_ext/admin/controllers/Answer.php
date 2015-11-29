<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @package     Question Answer (https://github.com/SunDi3yansyah/FinalProjectPWL)
 * @author      Cahyadi Triyansyah (https://sundi3yansyah.com)
 * @version     1.0
 * @license     MIT
 * @copyright   Copyright (c) 2015 SunDi3yansyah
 */
class Answer extends CI_Privates
{
	function index()
	{
        $data = array(
            'dataTables' => TRUE,
            'dtFields' => array(
                'id_answer',
                'username',
                'subject',
                'answer_date',
                ),
            );
		$this->_render('answer/index', $data);
	}

	function ajax()
	{
        if (!$this->input->is_ajax_request())
        {
            exit('No direct script access allowed');
        }
        else
        {
            $table = 'pwl_answer';

            $primaryKey = 'id_answer';

            $columns = array(
                array('db' => 'id_answer', 'dt' => 'id_answer'),
                array('db' => 'username', 'dt' => 'username'),
                array('db' => 'subject', 'dt' => 'subject'),
                array('db' => 'answer_date', 'dt' => 'answer_date'),
                array(
                    'db' => 'id_answer',
                    'dt' => 'action',
                    'formatter' => function($id)
                    {
                        return '<a href="' . base_url(''.$this->uri->segment(1).'/'.$this->uri->segment(2).'/view/' . $id) . '" class="btn btn-info btn-sm">View</a> <a href="' . base_url(''.$this->uri->segment(1).'/'.$this->uri->segment(2).'/update/' . $id) . '" class="btn btn-primary btn-sm">Update</a> <a href="' . base_url(''.$this->uri->segment(1).'/'.$this->uri->segment(2).'/delete/' . $id) . '" class="btn btn-danger btn-sm">Delete</a>';
                    }
                ),
            );

            $joinQuery = "FROM `pwl_answer` JOIN `pwl_user` ON `pwl_answer`.`user_id`=`pwl_user`.`id_user` JOIN `pwl_question` ON `pwl_answer`.`question_id`=`pwl_question`.`id_question`";

            $sql_details = array(
                'user' => $this->db->username,
                'pass' => $this->db->password,
                'db' => $this->db->database,
                'host' => $this->db->hostname
                );

            $this->output
                 ->set_content_type('application/json')
                 ->set_output(json_encode(Datatables_join::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery), JSON_PRETTY_PRINT));
        }
	}

    function view($str = NULL)
    {
        if (isset($str))
        {
            $data = $this->_get($str);
            if (!empty($data))
            {
                $answer = $this->qa_model->join2_where('answer', 'user', 'question', 'answer.user_id=user.id_user', 'answer.question_id=question.id_question', array('answer.question_id' => $str), 'answer.question_id');
                foreach ($answer as $get)
                {
                    redirect('question/' . $get->url_question);
                }
            }
            else
            {
                show_404();
                return FALSE;
            }
        }
        else
        {
            show_404();
            return FALSE;
        }
    }

    function update($str = NULL)
    {
        if (isset($str))
        {
            $data = array(
                'record' => $this->_get($str),
                );
            if (!empty($data['record']))
            {
                $this->form_validation->set_rules('description_answer', 'Description', 'trim|required|min_length[25]|max_length[5000]|xss_clean');
                $this->form_validation->set_error_delimiters('', '<br>');
                if ($this->form_validation->run() == TRUE)
                {
                    $update = array(
                        'description_answer' => $this->input->post('description_answer', TRUE),
                        'answer_update' => date('Y-m-d H:i:s'),
                        );
                    $this->qa_model->update('answer', $update, array('id_answer' => $str));
                    redirect($this->uri->segment(1) .'/'. $this->uri->segment(2));
                }
                else
                {
                    $data['record_join'] = $this->qa_model->join2_where('answer', 'user', 'question', 'answer.user_id=user.id_user', 'answer.question_id=question.id_question', array('answer.question_id' => $str), 'answer.question_id');
                    $this->_render('answer/update', $data);
                }
            }
            else
            {
                show_404();
                return FALSE;
            }
        }
        else
        {
            show_404();
            return FALSE;
        }
    }

    function delete($str = NULL)
    {
        if (isset($str))
        {
            $data = $this->_get($str);
            if (!empty($data))
            {
                $this->qa_model->delete('answer', array('id_answer' => $str));
                redirect($this->uri->segment(1) .'/'. $this->uri->segment(2));
            }
            else
            {
                show_404();
                return FALSE;
            }
        }
        else
        {
            show_404();
            return FALSE;
        }
    }

    function _get($str)
    {
        $var = $this->qa_model->get('answer', array('id_answer' => $str));
        return ($var == FALSE)?array():$var;
    }
}