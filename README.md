### How to run project
> make project-up

APIs:

🔴 create order sample(just for test):

post: api/user/orders body:{name: "", delivery_time: 20, created_at: "2024-05-03 12:00:00"}
- name of order
- delivery_time order
- created_at order

🔴 user delay report:

put: api/user/{user_id}/orders/{order_id} body:{}

🔴 agent request to assign report to own:

put: api/agent/orders/assign body:{agent_name: "test"}
- name of agent

🔴 panel list of delay reports of vendor:

get: api/panel/orders/report body:{}

### Test API swagger
> http://localhost:8020/api/documentation

### Run Project Test
> docker compose exec app php artisan test