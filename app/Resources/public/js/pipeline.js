define(['require', 'jquery', 'frameworks/spine', 'frameworks/manager'], function(require) {
	
	/* Require definitions */
	
	/* Set up controllers */
	var OverviewController = Spine.Controller.sub();
	var DashbaordController = Spine.Controller.sub();
	
	/* Add to the manager */
	var overview = new OverviewController;
	var dashboard = new DashbaordController;
	
	//var Pipeline_Manager = new Spine.Manager(overview, dashboard);
	
	/* Initialize function for setting up views */
	var initialize = function(){
		console.log("let's start");
	}
	
	/* The primary application controller */
	var app = function() { 
		return "test";
	}
	
	return {
		initialize: initialize,
		app: app
	};

});