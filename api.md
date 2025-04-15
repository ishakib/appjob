# Laravel Test App API Documentation

## Base URL
```
{{base_url}}
```

---

## 1. Get Nearest Riders
### Endpoint:
```
GET /riders?restaurant_id={restaurant_id}
```

### Description:
Retrieve a list of nearest riders to a given restaurant.

### Request Parameters:
| Parameter     | Type   | Required | Description |
|--------------|--------|----------|-------------|
| restaurant_id | int    | Yes      | The ID of the restaurant to find the nearest riders. |

### Example Request:
```
GET {{base_url}}/riders?restaurant_id=1
```

### Response:
```json
{
    "message": "Nearest riders found",
    "data": [
        {
            "id": 5,
            "uid": "abc123",
            "name": "John Doe",
            "status": 1,
            "distance": 3.75
        },
        {
            "id": 12,
            "uid": "xyz456",
            "name": "Alice Smith",
            "status": 1,
            "distance": 4.21
        }
    ]
}
```

---

## 2. Update Rider's Location
### Endpoint:
```
PATCH /riders/{RiderUid}/location/update
```

### Description:
Update the location of a rider.

### URL Parameters:
| Parameter  | Type   | Required | Description |
|------------|--------|----------|-------------|
| RiderUid   | string | Yes      | Unique identifier of the rider whose location is being updated. |

### Request Body:
| Parameter  | Type   | Required | Description |
|------------|--------|----------|-------------|
| latitude   | float  | Yes      | Rider's current latitude. |
| longitude  | float  | Yes      | Rider's current longitude. |
| accuracy   | float  | No       | Accuracy of the location in meters. |
| speed      | float  | No       | Rider's current speed in km/h. |
| direction  | float  | No       | Rider's movement direction in degrees. |
| timestamp  | string | Yes      | ISO 8601 timestamp of the location update. |
| status     | int    | Yes      | Rider's status (e.g., 1 for active). |

### Example Request:
```json
PATCH {{base_url}}/riders/rdi-ktrj-ZinMyUyc-gzt8/location/update
Content-Type: application/json

{
  "latitude": 23.8103,
  "longitude": 90.4125,
  "accuracy": 5,
  "speed": 12.5,
  "direction": 180,
  "timestamp": "2025-02-26T14:30:00Z",
  "status": 1
}
```

### Response:
```json
{
    "message": "Rider location updated successfully",
    "data": {
        "rider_id": "rdi-ktrj-ZinMyUyc-gzt8",
        "latitude": 23.8103,
        "longitude": 90.4125,
        "accuracy": 5,
        "speed": 12.5,
        "direction": 180,
        "timestamp": "2025-02-26T14:30:00Z",
        "status": 1
    }
}
```

