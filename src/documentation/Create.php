<?php

namespace Documentation;

/**
 * @OA\Post(
 *     path="/api/user/orders",
 *     tags={"User"},
 *
 *     @OA\RequestBody(
 *
 *         @OA\MediaType(
 *             mediaType="application/json",
 *
 *             @OA\Schema(
 *
 *                 @OA\Property(
 *                      type="object",
 *                      @OA\Property(
 *                          property="name",
 *                          type="string"
 *                      ),
 *                      @OA\Property(
 *                          property="delivery_time",
 *                          type="string"
 *                      ),
 *                      @OA\Property(
 *                          property="created_at",
 *                          type="string"
 *                      ),
 *                      @OA\Property(
 *                          property="trip_status",
 *                          type="integer"
 *                      ),
 *                 ),
 *                 example={
 *                     "name":"John",
 *                     "delivery_time":15,
 *                     "created_at":"2024-05-04 12:00:00",
 *                     "trip_status":1,
 *                }
 *             )
 *         )
 *      ),
 *
 *      @OA\Response(
 *          response=200,
 *          description="Success",
 *
 *          @OA\JsonContent(
 *              anyOf={
 *
 *                  @OA\Property(type="object",
 *                      @OA\Property(property="user_id", type="number", example=1),
 *                      @OA\Property(property="order_id", type="number", example=1),
 *                      @OA\Property(property="estimate_delivered_at", type="string", example="2024-05-04 12:15:00"),
 *                  ),
 *              }
 *          )
 *      ),
 *
 *      @OA\Response(
 *          response=422,
 *          description="Validation error",
 *
 *          @OA\JsonContent(
 *
 *              @OA\Property(property="message", type="string", example="The name field is required. (and 2 more errors)"),
 *          )
 *      )
 * )
 */ class Create
{
}
