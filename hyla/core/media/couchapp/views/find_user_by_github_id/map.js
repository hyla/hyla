function(doc) {
	if (doc.model !== 'user') {
		return; // Searching for users
	}

	if (doc.github) {
		if (doc.github.id) {
			emit(doc.github.id, 1);
		}
	}
}