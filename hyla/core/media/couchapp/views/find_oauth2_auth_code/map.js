function(doc) {
	if (doc.model === 'oauth2_auth_code') {
		emit([doc.code, doc.client_id], 1);
		emit([doc.code, null], 1);
	}
}