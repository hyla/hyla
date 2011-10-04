function(doc) {
	if (doc.model !== 'user') {
		return; // Searching for users
	}

	if (doc["notification-settings"]) {
		var settings = doc["notification-settings"];

		for (var category in settings) {
			var len = settings[category].length;
			for(var i=0; i<len; i++) {
				emit(category + '.' + settings[category][i], 1);
			}
		}
	}
}