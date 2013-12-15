define(['require', 
		'jquery', 
		'frameworks/spine', 
		'frameworks/manager', 
		'frameworks/ajax',
		'model'
		], function(require) {
	
	/* Require definitions */
	var Model = require('model');
	var Task = Model.task;
	
	/* Initialize function for setting up views */
	var initialize = function(){
		var app = new Application();
		
		/* Fetch the model! */
		Task.fetch();
		
		return app;
	}	
	
	/* Set up controllers */
	var NavigationSidebar = Spine.Controller.sub({ 
		el: $('#sidebar')
	});
	
	var TasksController = Spine.Controller.sub({ 
		el: $('#tasks_template'), 
		
		init: function() 
		{ 		
			console.log("tasks logged");
		}
	});
	
	
	var DashbaordController = Spine.Controller.sub({ 
		
	});
	
	/* The primary application controller */
	var Application = Spine.Controller.sub({
		
		elements: { 
			"#content": "content"
		},
		
		init: function() { 
			/* Add to the manager */
			this.taskController = new TasksController({ content: this.content });
			this.dashboardController = new DashbaordController({ content: this.content });
			
			this.manager = new Spine.Manager(this.taskController, this.dashboardController);
			
			this.taskController.active();
		}
		
	});
	
	return {
		initialize: initialize,
	};

});