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
		
	});
	
	
	var DashbaordController = Spine.Controller.sub({ 
		
	});
	
	/* The primary application controller */
	var Application = Spine.Controller.sub({
		
		init: function() { 
			/* Add to the manager */
			this.taskController = new TasksController;
			this.dashboardController = new DashbaordController;
			
			this.manager = new Spine.Manager(this.taskController, this.dashboardController);
			
		}
		
	});
	
	return {
		initialize: initialize,
	};

});