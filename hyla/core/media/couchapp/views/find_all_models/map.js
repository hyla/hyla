function(doc) {
	if (doc.model) {
		emit(doc.model, 1);
	}
}