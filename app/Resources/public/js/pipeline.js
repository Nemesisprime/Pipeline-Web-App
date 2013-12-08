define(['require', 
		'jquery', 
		'frameworks/spine', 
		'frameworks/manager', 
		'frameworks/ajax'
		], function(require) {
	
	/* Require definitions */
	
	/* Initialize function for setting up views */
	var initialize = function(){
		var app = new Application();
		
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