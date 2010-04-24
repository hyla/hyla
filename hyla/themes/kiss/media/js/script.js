$('body').addClass('jsEnabled');

/** App config **/
var CONFIG =
{
	inlineActions:
	{
		rootClass: '.inline-actions',
		actionsPath: 'dt',
		descriptionsPath: 'dd',
	}
};

var inline_actions;

inline_actions =  $(CONFIG.inlineActions.rootClass);

if(inline_actions)
{
	var descriptions;
	var actions;
	var description;

	inline_actions.hide();

	inline_actions.parent()
		.mouseover(function(){
			$(this).children(CONFIG.inlineActions.rootClass).show();
		})
		.mouseout(function(){
			$(this).children(CONFIG.inlineActions.rootClass).hide();
		});


	inline_actions.each(function(){
		actions = $(this).find(CONFIG.inlineActions.actionsPath);
		descriptions = $(this).find(CONFIG.inlineActions.descriptionsPath);

		descriptions.hide();

		actions.mouseover(function(){
			$(this).siblings('.' + $(this).attr('class')).show();
		});

		actions.mouseout(function(){
			$(this).siblings('.' + $(this).attr('class')).hide();
		});
	});
}