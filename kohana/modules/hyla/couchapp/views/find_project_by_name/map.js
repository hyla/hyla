function(doc) {
	if (doc.model === 'project') {
		emit(doc.name, 1);
	}
}