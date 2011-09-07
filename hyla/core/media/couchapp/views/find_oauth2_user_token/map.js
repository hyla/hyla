function(doc) {
	if (doc.model === 'oauth2_user_token') {
		emit([doc.provider, doc.user_id], 1);
	}
}