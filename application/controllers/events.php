<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include('backend.php');

class Events extends Backend {
	
	public function __construct()
    {
    	parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('Event_Model');
		$this->load->model('Scheduled_Event_Model');
		$this->load->model('Knowledge_Model');
		$this->load->model('Sale_Model');
		$this->load->model('Place_Model');
		$this->load->model('Planning_Model');
    }
	
	public function index()
	{
		$this->check_session();
		$data['title']      = "Eventos";
		$data['controller'] = 'List';
		$data['rows']  = $this->Scheduled_Event_Model->get_all_scheduled_events();
		$this->load_view('event/index',$data);
	}
	
	public function new_event($phase = 1)
	{
		$this->check_session();
		$data['controller'] = 'New_Event';
		
		if ($phase == 1)
		{
			$this->load_view('event/new',$data);
		}
		else
		{
			$this->form_validation->set_rules('Type'       , 'Tipo Evento', 'trim|required|xss_clean');
			$this->form_validation->set_rules('Name'       , 'Nombre', 'trim|required|xss_clean');
			$this->form_validation->set_rules('Purpose'    , 'Propuesta', 'trim|required|xss_clean');
			$this->form_validation->set_rules('Start_Date' , 'Fecha Inicio', 'trim|required|xss_clean');
			$this->form_validation->set_rules('End_Date'   , 'Fecha Fin', 'trim|required|xss_clean');
			$this->form_validation->set_rules('Mode'       , 'Modo del Evento', 'trim|required|xss_clean');
			$this->form_validation->set_rules('Quota'      , 'Capacidad del Evento', 'trim|required|xss_clean');
			$this->form_validation->set_rules('Status'     , 'Estatus', 'trim|required|xss_clean');
			$this->form_validation->set_rules('Slogan'     , 'Slogan', 'trim|required|xss_clean');
			$this->form_validation->set_rules('Hours'      , 'Horas', 'trim|required|xss_clean');
			
			$this->form_validation->set_message('required', '%s es requerido');
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->new_event(1);
			}
			else
			{
				if ($this->Event_Model->insert_event($this->input))
				{
					$_POST['Event_Id'] = $this->db->insert_id();
					if ($this->Scheduled_Event_Model->insert_scheduled_event($this->input))
					{
						$this->success_view('Éxito','El evento se ha guardado');
						$this->index();
					}
					else
					{
						$this->error_view('Error','Oh oh. Algo malo ha pasado con la programación evento');
						$this->new_event(1);
					}
				}
				else
				{
					$this->error_view('Error','Oh oh. Algo malo ha pasado con el evento');
					$this->new_event(1);
				}
			}
		}
	}
	
	public function scheduled($phase = 1)
	{
		$this->check_session();
		$data['controller'] = 'Scheduled';
		
		if ($phase == 1)
		{
			$data['rows'] = $this->Event_Model->get_all_events();
			$this->load_view('event/scheduled',$data);
		}
		else
		{
			$this->form_validation->set_rules('Event_Id'   , 'Evento', 'trim|required|xss_clean');
			$this->form_validation->set_rules('Start_Date' , 'Fecha Inicio', 'trim|required|xss_clean');
			$this->form_validation->set_rules('End_Date'   , 'Fecha Fin', 'trim|required|xss_clean');
			$this->form_validation->set_rules('Mode'       , 'Modo del Evento', 'trim|required|xss_clean');
			$this->form_validation->set_rules('Quota'      , 'Capacidad del Evento', 'trim|required|xss_clean');
			$this->form_validation->set_rules('Status'     , 'Estatus', 'trim|required|xss_clean');
			$this->form_validation->set_rules('Slogan'     , 'Slogan', 'trim|required|xss_clean');
			$this->form_validation->set_rules('Hours'      , 'Horas', 'trim|required|xss_clean');
			
			$this->form_validation->set_message('required', '%s es requerido');
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->scheduled(1);
			}
			else
			{
				if ($this->Scheduled_Event_Model->insert_scheduled_event($this->input))
				{
					$this->success_view('Éxito','El evento se ha programado');
					$this->index();
				}
				else
				{
					$this->error_view('Error','Oh oh. Algo malo ha pasado con la programación evento');
					$this->scheduled(1);
				}
			}
		}
	}
	
	public function view($id)
	{
		$this->check_session();
		$data['controller'] = 'View_Event';
		$data['event']      = $this->Scheduled_Event_Model->get_by_id($id);
		
		if($data['event']!=0)
		{
			$data['knowledges'] = $this->Knowledge_Model->get_all_knowledges_by_scheduled_event($data['event'][0]->Id);
			$data['costs']      = $this->Sale_Model->get_all_sales_with_cost_by_scheduled_event($data['event'][0]->Id);
			$data['places']     = $this->Place_Model->get_all_places_by_scheduled_event($data['event'][0]->Id);
			$data['planning']   = $this->Planning_Model->get_all_planning_by_scheduled_event($data['event'][0]->Id);
			$this->load_view('event/view',$data);
		}
		else
		{
			$this->error_view('Error','Oh oh. Algo malo ha pasado con la carga de la data del evento');
			$this->index();
		}
	}
	
	public function edit($id,$phase = 1)
	{
		$this->check_session();
		$data['controller'] = 'Edit_Event';
		
		if ($phase == 1)
		{
			$data['rows']  = $this->Event_Model->get_all_events();
			$data['event'] = $this->Scheduled_Event_Model->get_by_id($id);
		
			if($data['event']!=0)
			{
				$this->load_view('event/edit',$data);
			}
			else
			{
				$this->error_view('Error','Oh oh. Algo malo ha pasado con la carga de la data del evento');
				$this->index();
			}
		}
		else
		{
			$this->form_validation->set_rules('Event_Id'   , 'Evento', 'trim|required|xss_clean');
			$this->form_validation->set_rules('Start_Date' , 'Fecha Inicio', 'trim|required|xss_clean');
			$this->form_validation->set_rules('End_Date'   , 'Fecha Fin', 'trim|required|xss_clean');
			$this->form_validation->set_rules('Mode'       , 'Modo del Evento', 'trim|required|xss_clean');
			$this->form_validation->set_rules('Quota'      , 'Capacidad del Evento', 'trim|required|xss_clean');
			$this->form_validation->set_rules('Status'     , 'Estatus', 'trim|required|xss_clean');
			$this->form_validation->set_rules('Slogan'     , 'Slogan', 'trim|required|xss_clean');
			$this->form_validation->set_rules('Hours'      , 'Horas', 'trim|required|xss_clean');
			
			$this->form_validation->set_message('required', '%s es requerido');
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->edit($id,1);
			}
			else
			{
				if ($this->Scheduled_Event_Model->update_scheduled_event($this->input))
				{
					$this->db->last_query();
					$this->success_view('Éxito','El evento se ha actualizado');
					$this->index();
				}
				else
				{
					$this->error_view('Error','Oh oh. Algo malo ha pasado con la actualización del evento');
					$this->edit($id,1);
				}
			}
		}
	}
	
	public function delete($id)
	{
		$this->check_session();
		if($this->Scheduled_Event_Model->delete_scheduled_event($id))
		{
			$this->success_view('Éxito','El evento se ha eliminado correctamente');
		}
		else
		{
			$this->error_view('Error','Oh oh. Algo malo ha pasado con la eliminación del evento');
		}
		$this->index();
	}
	
	public function knowledges($id = '')
	{
		$this->check_session();
		$data['controller'] = 'List';
		
		if($id=='')
		{
			$this->error_view('Error','Oh oh. Algo malo ha pasado con la carga del evento');
			$this->index();
		}
		
		$data['event'] = $this->Scheduled_Event_Model->get_by_id($id);
		
		if($data['event']!=0)
		{
			$data['rows'] = $this->Knowledge_Model->get_all_knowledges_by_scheduled_event($id);
			$this->load_view('event/knowledges',$data);
		}
		else
		{
			$this->error_view('Error','Oh oh. Algo malo ha pasado con la carga de la data del evento');
			$this->index();
		}
	}
	
	public function new_knowledge($id = '',$phase = 1)
	{
		$this->check_session();
		$data['controller'] = 'New_Knowledges';
		
		if ($phase == 1)
		{
			if($id=='')
			{
				$this->error_view('Error','Oh oh. Algo malo ha pasado con la carga del evento');
				$this->index();
			}
			
			$data['event'] = $this->Scheduled_Event_Model->get_by_id($id);
		
			if($data['event']!=0)
			{
				$this->load_view('event/new_knowledge',$data);
			}
			else
			{
				$this->error_view('Error','Oh oh. Algo malo ha pasado con la carga de la data del evento');
				$this->index();
			}
		}
		else
		{
			$this->form_validation->set_rules('Content' , 'Saber', 'trim|required|xss_clean');
			
			$this->form_validation->set_message('required', '%s es requerido');
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->new_knowledge($id,1);
			}
			else
			{
				if($this->Knowledge_Model->insert_knowledge($this->input))
				{
					$this->success_view('Éxito','El saber se ha guardado correctamente');
					$this->knowledges($id);
				}
				else
				{
					$this->error_view('Error','Oh oh. Algo malo ha pasado con el guardado del saber');
					$this->new_knowledge($id,1);
				}
			}
		}
	}
	
	public function edit_knowledge($id = '',$phase = 1)
	{
		$this->check_session();
		$data['controller'] = 'Edit_Event';
		
		if ($phase == 1)
		{
			$data['knowledge'] = $this->Knowledge_Model->get_by_id($id);
		
			if($data['knowledge']!=0)
			{
				$data['event'] = $this->Scheduled_Event_Model->get_by_id($data['knowledge'][0]->Scheduled_Event_Id);
				$data['count'] = $this->Knowledge_Model->get_count_by_scheduled_event($data['knowledge'][0]->Scheduled_Event_Id);
				$this->load_view('event/edit_knowledge',$data);
			}
			else
			{
				$this->error_view('Error','Oh oh. Algo malo ha pasado con la carga de la data del saber');
				$this->index();
			}
		}
		else
		{
			$this->form_validation->set_rules('Order'   , 'Orden', 'trim|required|xss_clean');
			$this->form_validation->set_rules('Content' , 'Saber', 'trim|required|xss_clean');
			
			$this->form_validation->set_message('required', '%s es requerido');
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->edit_knowledge($id,1);
			}
			else
			{
				if($this->Knowledge_Model->update_knowledge($this->input))
				{
					$this->success_view('Éxito','El saber se ha actualizado correctamente');
					$this->knowledges($this->input->post('Scheduled_Event_Id'));
				}
				else
				{
					$this->error_view('Error','Oh oh. Algo malo ha pasado con el actualizar del saber');
					$this->edit_knowledge($id,1);
				}
			}
		}
	}
	
	public function delete_knowledge($id)
	{
		$this->check_session();
		$data['knowledge'] = $this->Knowledge_Model->get_by_id($id);
		
		if($data['knowledge']!=0)
		{
			$data['event'] = $this->Scheduled_Event_Model->get_by_id($data['knowledge'][0]->Scheduled_Event_Id);
			if($this->Knowledge_Model->delete_knowledge($id))
			{
				$this->success_view('Éxito','El saber se ha eliminado correctamente');
			}
			else
			{
				$this->error_view('Error','Oh oh. Algo malo ha pasado con la eliminación del saber');
			}
			$this->knowledges($data['knowledge'][0]->Scheduled_Event_Id);
		}
		else
		{
			$this->error_view('Error','Oh oh. Algo malo ha pasado con la data que nos suministraste');
			$this->index();
		}
	}
	
	public function planning($id = '')
	{
		$this->check_session();
		$data['controller'] = 'List';
		
		if($id=='')
		{
			$this->error_view('Error','Oh oh. Algo malo ha pasado con la carga del evento');
			$this->index();
		}
		
		$data['event'] = $this->Scheduled_Event_Model->get_by_id($id);
		
		if($data['event']!=0)
		{
			$data['rows'] = $this->Planning_Model->get_all_planning_by_scheduled_event($id);
			$this->load_view('event/planning',$data);
		}
		else
		{
			$this->error_view('Error','Oh oh. Algo malo ha pasado con la carga de la data del evento');
			$this->index();
		}
	}
	
	public function new_plan($id = '',$phase = 1)
	{
		$this->check_session();
		$data['controller'] = 'New_Planning';
		
		if ($phase == 1)
		{
			if($id=='')
			{
				$this->error_view('Error','Oh oh. Algo malo ha pasado con la carga del evento');
				$this->index();
			}
			
			$data['event'] = $this->Scheduled_Event_Model->get_by_id($id);
		
			if($data['event']!=0)
			{
				$this->load_view('event/new_plan',$data);
			}
			else
			{
				$this->error_view('Error','Oh oh. Algo malo ha pasado con la carga de la data del evento');
				$this->index();
			}
		}
		else
		{
            $this->form_validation->set_rules('Description' , 'Descripción', 'trim|required|xss_clean');
			$this->form_validation->set_rules('Start_Date' , 'Fecha Inicio', 'trim|required|xss_clean');
            $this->form_validation->set_rules('End_Date' , 'Fecha Fin', 'trim|required|xss_clean');
			
			$this->form_validation->set_message('required', '%s es requerido');
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->new_plan($id,1);
			}
			else
			{
				if($this->Planning_Model->insert_planning($this->input))
				{
					$this->success_view('Éxito','La actividad se ha guardado correctamente');
					$this->planning($id);
				}
				else
				{
					$this->error_view('Error','Oh oh. Algo malo ha pasado con el guardado de l actividad');
					$this->new_plan($id,1);
				}
			}
		}
	}
	
	public function edit_plan($id = '',$phase = 1)
	{
		$this->check_session();
		$data['controller'] = 'Edit_Planning';
		
		if ($phase == 1)
		{
			$data['plan'] = $this->Planning_Model->get_by_id($id);
		
			if($data['plan']!=0)
			{
				$data['event'] = $this->Scheduled_Event_Model->get_by_id($data['plan'][0]->Scheduled_Event_Id);
				$this->load_view('event/edit_plan',$data);
			}
			else
			{
				$this->error_view('Error','Oh oh. Algo malo ha pasado con la carga de la data de la actividad');
				$this->index();
			}
		}
		else
		{
			$this->form_validation->set_rules('Description' , 'Descripción', 'trim|required|xss_clean');
			$this->form_validation->set_rules('Start_Date' , 'Fecha Inicio', 'trim|required|xss_clean');
            $this->form_validation->set_rules('End_Date' , 'Fecha Fin', 'trim|required|xss_clean');
			
			$this->form_validation->set_message('required', '%s es requerido');
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->edit_plan($id,1);
			}
			else
			{
				if($this->Planning_Model->update_planning($this->input))
				{
					$this->success_view('Éxito','La actividad se ha actualizado correctamente');
					$this->planning($this->input->post('Scheduled_Event_Id'));
				}
				else
				{
					$this->error_view('Error','Oh oh. Algo malo ha pasado con el actualizar de la actividad');
					$this->edit_plan($id,1);
				}
			}
		}
	}
	
	public function delete_planning($id)
	{
		$this->check_session();
		$data['plan'] = $this->Planning_Model->get_by_id($id);
		
		if($data['plan']!=0)
		{
			if($this->Planning_Model->delete_planning($id))
			{
				$this->success_view('Éxito','La actividad se ha eliminado correctamente');
			}
			else
			{
				$this->error_view('Error','Oh oh. Algo malo ha pasado con la eliminación de la actividad');
			}
			$this->planning($data['plan'][0]->Scheduled_Event_Id);
		}
		else
		{
			$this->error_view('Error','Oh oh. Algo malo ha pasado con la data que nos suministrate');
			$this->index();
		}
		
	}
}