define(['require', 
		'jquery', 
		'frameworks/spine',
		'frameworks/ajax'
		], function(require) {
		
	
   /**
    * Task model 
    */
	var Task = Spine.Model.sub();
	Task.configure('Task', 'name', 
						   'status', 
						   'owner', 
						   'description', 
						   'created_at', 
						   'updated_at', 
						   'scheduled_at', 
						   'due_at', 
						   'priority',
						   'completed_at', 
						   'subtasks', 
						   'parentTask');
	Task.extend(Spine.Model.Ajax);
	Task.extend({
		url: Global.settings.url+"api/tasks"
	});
		
		
   /**
    * Return models
    */
	return {
		task: Task,
	};
		
});