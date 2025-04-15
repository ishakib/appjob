# Laravel Job App API Documentation

## Base URL
```
{{base_url}}
```

---

## Job Posts

### 1. Get all job posts
**Endpoint:**
```
GET /job-posts
```
**Example Request:**
```
GET {{base_url}}/job-posts
```

---

### 2. Get job post details
**Endpoint:**
```
GET /job-posts/{uid}
```
**Example Request:**
```
GET {{base_url}}/job-posts/{uid}
```

---

### 3. Create a new job post
**Endpoint:**
```
POST /job-posts
```
**Payload:**
```json
{
  "title": "Frontend Developer",
  "description": "Job description here",
  "company_name": "Awesome Inc."
}
```

---

### 4. Update a job post
**Endpoint:**
```
PUT /job-posts/{uid}/update
```
**Payload:**
```json
{
  "title": "Updated Job Title",
  "description": "Updated description"
}
```

---

### 5. Delete a job post
**Endpoint:**
```
DELETE /job-posts/{uid}
```

---

## Applications

### 6. Get all applications
```
GET /applications
```

### 7. Get application details
```
GET /applications/{uid}
```

### 8. Submit an application
```
POST /applications
```
**Payload:**
```json
{
  "candidate_uid": "xyz789",
  "job_post_uid": "abc123"
}
```

### 9. Update application
```
PUT /applications/{uid}/update
```

### 10. Delete application
```
DELETE /applications/{uid}
```

---

## Candidates

### 11. Get all candidates
```
GET /candidates
```

### 12. Get candidate details
```
GET /candidates/{uid}
```

### 13. Create a candidate
```
POST /candidates
```
**Payload:**
```json
{
  "name": "John Doe",
  "email": "john@example.com"
}
```

### 14. Update candidate
```
PUT /candidates/{uid}/update
```

### 15. Delete candidate
```
DELETE /candidates/{uid}
```

---

## Tenants

### 16. Get all tenants
```
GET /tenants
```

### 17. Get tenant details
```
GET /tenants/{uid}
```

### 18. Create a tenant
```
POST /tenants
```
**Payload:**
```json
{
  "company_name": "Awesome Inc.",
  "domain": "awesome.com"
}
```

### 19. Update tenant
```
PUT /tenants/{uid}/update
```

### 20. Delete tenant
```
DELETE /tenants/{uid}
```

