# Laravel Job App API Documentation

## Base URL
```
{{base_url}}
```

```
{
    "status": "SUCCESS",
    "code": 20000,
    "message": "response.success",
    "details": "",
    "locale": "en",
    "data": {
        "jobs": [
            {
                "uid": "baa1909d-607e-4f30-bb1c-4f9084a8f97d",
                "title": "Coil Winders",
                "slug": "perferendis-libero-accusantium-enim",
                "description": "Accusamus dicta perferendis quis aut consequatur. Ea velit quos et tenetur minus eum et. Ut quas ipsa modi vitae architecto temporibus est.",
                "view_count": 0,
                "application_count": 0,
                "company_name": "Default Tenant"
            },
            {
                "uid": "c2b3138f-b96d-40ca-b37e-cacedbfa402b",
                "title": "Public Transportation Inspector",
                "slug": "ut-ipsum-et",
                "description": "Illum delectus et doloribus eum tempora aut. Quia doloribus quia architecto fugiat. Iusto rerum dolores sed eveniet.",
                "view_count": 0,
                "application_count": 0,
                "company_name": "Default Tenant"
            },
            {
                "uid": "cfece236-cf39-4c95-af54-b1a9139c1cc8",
                "title": "Construction Manager",
                "slug": "enim-aut-sit-accusamus-ab",
                "description": "Deserunt maxime id laudantium recusandae alias. Perferendis eos vel aut id magni incidunt. In fugiat fugit deserunt.",
                "view_count": 0,
                "application_count": 0,
                "company_name": "Default Tenant"
            },
            {
                "uid": "d959f08d-c62d-414d-9c7b-cb44902a00d6",
                "title": "Concierge",
                "slug": "dolor-quibusdam",
                "description": "Ducimus ratione quaerat aliquam. Molestias nisi autem ullam enim minus quia. Maxime rerum sint alias quo temporibus sit autem.",
                "view_count": 0,
                "application_count": 0,
                "company_name": "Default Tenant"
            },
            {
                "uid": "70d78c41-f0d9-456f-9e19-6e4373587366",
                "title": "Air Traffic Controller",
                "slug": "sunt-distinctio-odio",
                "description": "Omnis quia quia doloremque molestiae provident voluptate tempora. Ad autem voluptas sapiente tenetur perferendis.",
                "view_count": 0,
                "application_count": 0,
                "company_name": "Default Tenant"
            },
            {
                "uid": "38579dd4-37fd-403a-a919-657ef5c9d7a6",
                "title": "Security Guard",
                "slug": "soluta-error-labore-dolor",
                "description": "Id qui eos corrupti qui soluta. Reiciendis rerum dolorum dignissimos laudantium at omnis consequuntur. Nulla architecto quia est dolore sed ad. Occaecati beatae consequatur aut quaerat.",
                "view_count": 0,
                "application_count": 0,
                "company_name": "Default Tenant"
            },
            {
                "uid": "f34428c7-7f93-4247-99b8-41dcb7acc401",
                "title": "Space Sciences Teacher",
                "slug": "eos-et-nobis-perspiciatis",
                "description": "Doloremque omnis molestiae officiis eum rerum. Magnam nemo nihil et debitis voluptatem ut. Voluptatem aut quam quo velit natus quasi id.",
                "view_count": 0,
                "application_count": 0,
                "company_name": "Default Tenant"
            },
            {
                "uid": "d58ec7de-bdfc-4bd2-8b12-528b2afbf19a",
                "title": "Graphic Designer",
                "slug": "dicta-quo-cumque",
                "description": "Accusamus quod aut et voluptas sunt. Assumenda quia iste tempore et quam ea. Adipisci et dolorem corporis et. Magnam qui voluptatem labore tempora deleniti.",
                "view_count": 0,
                "application_count": 0,
                "company_name": "Default Tenant"
            },
            {
                "uid": "8141664f-978b-461a-b150-7b207257f6db",
                "title": "Electro-Mechanical Technician",
                "slug": "aut-harum-blanditiis",
                "description": "Impedit eius et temporibus debitis sint non quia consequuntur. Quod ut et modi mollitia. Quis dolore eius qui ab asperiores. Fugiat corrupti laudantium similique illum. Aut aliquid pariatur expedita aut hic deleniti.",
                "view_count": 0,
                "application_count": 0,
                "company_name": "Default Tenant"
            },
            {
                "uid": "35638637-b958-40ac-b48a-51b26c78a99b",
                "title": "Lifeguard",
                "slug": "voluptas-laudantium-perferendis",
                "description": "Facilis dolorum iure et eum incidunt. Maiores consequatur est non. Rerum autem voluptatem enim et.",
                "view_count": 0,
                "application_count": 0,
                "company_name": "Default Tenant"
            }
        ],
        "meta": {
            "cur_page_total": 10,
            "current_page": 1,
            "last_page": 1,
            "has_more": false,
            "next_page_url": null,
            "total": 10,
            "per_page": 10
        }
    }
}
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

