function(doc) {
	if (doc.model === 'oauth2_client') {
		emit([doc.client_id, doc.client_secret], 1);
		emit([doc.client_id, null], 1);
	}
}