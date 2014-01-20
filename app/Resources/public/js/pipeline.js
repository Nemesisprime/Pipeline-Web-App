define(['require', 
		'jquery', 
		'frameworks/spine', 
		'frameworks/manager', 
		'frameworks/ajax',
		'model',
		'template'
		], function(require) {
	
	/* Couple Constants */
	var Constants = new Object();
	Constants = { 
		STATUS_ACTIVE: 0,
		STATUS_COMPLETE: 1, 
		STATUS_PENDING: 2, 
		STATUS_REJECTED: 3, 
		STATUS_REQUEST: 4, 
		
		PRIORITY_HIGH: 3,
		PRIORITY_MEDIUM: 2, 
		PRIORITY_LOW: 1
	}
	
	/* Require definitions */
	var Model = require('model');
	var Task = Model.task;
	var Template = require('template');
	
	/* Initialize function for setting up the application */
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
			var tasklistController = new TaskListController();
		}
	});
	
	var TaskListController = Spine.Controller.sub({ 
		el: $('#task-list'), 
		
		init: function() 
		{ 		
			Task.bind("refresh", this.proxy(this.addAll));
			Task.bind("create", this.proxy(this.addOne));
		},
		
		addAll: function()
		{ 
			var $this = this;
			var tasks = Task.findAllByAttribute("status", Constants.STATUS_ACTIVE);
			$.each(tasks, function(i, item) { $this.proxy($this.addOne(item)); });
		}, 
		
		addOne: function(item) 
		{ 
			var taskitem = new TaskItem({task: item});
		    this.append(taskitem.render());
		}
	});
	
	var TaskItem = Spine.Controller.sub({ 
		
		tag: 'li',
		
		className: 'task-item',
	
		events: {
			"click .complete-box": "complete"
		},
		
		elements: { 
			'.complete-box': 'completebox'
		},
		
		init: function()
		{
 			if (!this.task) throw "@item required";
			
			this.task.bind("update", this.proxy(this.render));
			this.task.bind("destroy", this.proxy(this.remove));
		},
		
		render: function(task)
		{
			if (task) this.task = task;
			
			this.html(this.template(this.task));
			return this;
		},
		
		template: function(task)
		{
			return Template.uikit.r('task-item', task);
		},
		
		remove: function()
		{
			this.el.remove();
		},
		
		complete: function()
		{	
			this.task.status = Constants.STATUS_COMPLETE;
			this.task.save();
		}
	});
	
	
	var DashbaordController = Spine.Controller.sub({ 
		
	});
	
	
	/* The primary application controller */
	var Application = Spine.Controller.sub({
		
		elements: { 
			"#content": "content"
		},
		
		init: function() 
		{ 
			/* Add to the manager */
			this.taskController = new TasksController({ app: this, content: this.content });
			this.dashboardController = new DashbaordController({ app: this, content: this.content });
			
			this.manager = new Spine.Manager(this.taskController, this.dashboardController);
			
			this.taskController.active();
		}
		
	});
	
	return {
		initialize: initialize,
	};

});