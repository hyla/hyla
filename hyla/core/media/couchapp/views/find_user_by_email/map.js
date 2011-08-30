function(doc) {
	if (doc.model !== 'user') {
		return; // Searching for users
	}

	if (doc.email) {
		emit(doc.email, 1);
	}
	if (doc.github) {
		if (doc.github.email) {
			emit(doc.github.email, 1);
		}
	}
}