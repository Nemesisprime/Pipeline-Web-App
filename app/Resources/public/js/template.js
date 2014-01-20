define(['require', 
		'jquery', 
		'frameworks/spine',
		'frameworks/handlebars'
		], function(require) {
		
	/* Precompile */
	var PreCompile = Spine.Class.sub({ 
		init: function(templates) 
		{ 
			this.templates = templates;
			
			this.globals();
		}, 
		
		globals: function() { 
			this.templates.add('task-item', '#task_item');
		}
	});
   	
   	/* Internal Template Engine */
	var TemplateEngine = Spine.Class.sub({ 
		init: function() 
		{ 
			this.template_store = new Array();
		},
		
		precompile: function() {
			var precompile = new PreCompile(this);
		},
		
		add: function(name, source) 
		{ 
			var source = $(source).html();
			this.template_store[name] = Handlebars.compile(source);
		},
		
		r: function(name, model) 
		{ 
			return this.template_store[name](model);
		}
	});
	
	/* Set up the internal template engine then precompile templates */
	var templates = new TemplateEngine;
	templates.precompile();
	
   /**
    * Return internal template engine
    */
	return {
		uikit: templates,
	};
		
});