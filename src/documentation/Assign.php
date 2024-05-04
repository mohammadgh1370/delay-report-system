<?php

namespace Documentation;

/**
 * @OA\Put(
 *     path="/api/agent/orders/assign",
 *     tags={"Agent"},
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                      type="object",
 *                      @OA\Property(
 *                          property="agent_name",
 *                          type="string"
 *                      ),
 *                 ),
 *                 example={
 *                     "agent_name":"John",
 *                }
 *             )
 *         )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Success",
 *          @OA\JsonContent(
 *              anyOf={
 *                  @OA\Property(type="object",
 *                      @OA\Property(property="id", type="number", example=1),
 *                      @OA\Property(property="order_id", type="number", example="John"),
 *                      @OA\Property(property="agent_id", type="number", example="Dou"),
 *                      @OA\Property(property="checked_at", type="string", example="2024-12-05 12:00:00"),
 *                      @OA\Property(property="created_at", type="string", example="2024-12-05 12:00:00"),
 *                  ),
 *              }
 *          )
 *      ),
 *      @OA\Response(
 *          response=400,
 *          description="Success",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Dont exist any delay report to assign."),
 *          )
 *      ),
 * )
 */
class Assign
{

}