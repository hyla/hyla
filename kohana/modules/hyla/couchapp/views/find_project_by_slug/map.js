function(doc) {
	if (doc.model === 'project') {
		emit(doc.slug, 1);
	}
}