<?php
 
Class Timer extends PluginBase
{


	protected $storage				 = 'DbStorage';
	static protected $name			 = 'Survey Timer';
	static protected $description	 = 'Whole survey timer plugin';



	public function init()
	{
		/**
		 * Here you should handle subscribing to the events your plugin will handle
		 */
		$this->subscribe('beforeCloseHtml');
		$this->subscribe('beforeSurveyPage');
		$this->subscribe('beforeQuestionRender', 'test');
		$this->subscribe('beforeSurveySettings');
		$this->subscribe('newSurveySettings');
		}

		
		
	public function beforeCloseHtml()
	{
//		die('asd');
//		$event = $this->getEvent();
//		$surveyid = $event->get('surveyId');
//		if (!empty($surveyid)) {
//			
//			/**
//			* set survey start time
//			*/
//		   $surveyid = $this->id;
//		   $timerKey = $surveyid;
//
//		   if(empty($_SESSION['timers'][$timerKey])) {
//			   $_SESSION['timers'][$timerKey] = time();
//		   }
//
//		   $timer = [
//			   'start' => $_SESSION['timers'][$timerKey],
//			   'end' => $_SESSION['timers'][$timerKey] + ((
//				   (int) trim($timerSettings = PluginSetting::model()->findByAttributes(array(
//					   'plugin_id'	=> Plugin::model()->findByAttributes(array('name'	=> 'Timer'))->id,
//					   'model_id'	=> $surveyid,
//					   'key'		=> 'sTimerDuration'
//				   ))->value, '"')
//			   )*60),
//			   'current' => time(),
//		   ];
//
//		   $html = "\n
//		   <script>\n
//			   var Timer = {\n
//				   \"start\": " . $timer['start'] . ",\n
//				   \"end\": " . $timer['end'] . ",\n
//				   \"current\": " . $timer['current'] . ",\n
//			   };\n
//		   </script>";
//			$event->set('html', $html);
//		}
	}
	
	
	public function beforeSurveyPage() 
	{
		$assetsUrl = Yii::app()->assetManager->publish(dirname(__FILE__) . '/assets');
        App()->clientScript->registerCssFile("$assetsUrl/timer.css");
		
		$assetsUrl = Yii::app()->assetManager->publish(dirname(__FILE__) . '/assets');
        App()->clientScript->registerScriptFile("$assetsUrl/timer.js");
		
		$assetsUrl = Yii::app()->assetManager->publish(dirname(__FILE__) . '/assets');
        App()->clientScript->registerScriptFile("$assetsUrl/imagemapster.js");
	}



	public function test()
	{
		$event = $this->event;
//		echo '<pre>';
//		var_dump($event->getContent($this));
//		echo '</pre>';
//		die('asd');
	}



	/**
	 * Add setting on survey level: send hook only for certain surveys / url setting per survey / auth code per survey / send user token / send question response
	 */
	public function beforeSurveySettings()
	{
		$oEvent = $this->event;
		$oEvent->set("surveysettings.{$this->id}", array(
			'name'		 => get_class($this),
			'settings'	 => array(
				'bUseTimer'		 => array(
					'type'		 => 'select',
					'label'		 => 'Enable timer',
					'options'	 => array(
						0	 => 'No',
						1	 => 'Yes'
					),
					'default'	 => 0,
					'help'		 => 'Timer for whole survey',
					'current'	 => $this->get('bUseTimer', 'Survey', $oEvent->get('survey')),
				),
				'sTimerDuration' => array(
					'type'		 => 'string',
					'label'		 => 'Time limit for whole survey',
					'help'		 => 'Minutes',
					'current'	 => $this->get('sTimerDuration', 'Survey', $oEvent->get('survey')),
				)
			),
		));
	}



	public function newSurveySettings()
	{
		$event = $this->event;
		foreach ($event->get('settings') as $name => $value) {
			$this->set($name, $value, 'Survey', $event->get('survey'));
		}
	}

}
