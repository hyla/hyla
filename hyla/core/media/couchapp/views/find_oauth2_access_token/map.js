function(doc) {
	if (doc.model === 'oauth2_access_token') {
		emit([doc.access_token, doc.client_id], 1);
		emit([doc.access_token, null], 1);
	}
}