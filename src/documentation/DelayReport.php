<?php

namespace Documentation;

/**
 * @OA\Put(
 *     path="/api/user/{user_id}/orders/{order_id}",
 *     tags={"User"},
 *
 *     @OA\Parameter(
 *         description="id of user",
 *         in="path",
 *         name="user_id",
 *         required=true,
 *
 *         @OA\Schema(
 *           type="integer",
 *         )
 *     ),
 *
 *     @OA\Parameter(
 *         description="id of order",
 *         in="path",
 *         name="order_id",
 *         required=true,
 *
 *         @OA\Schema(
 *           type="integer",
 *         )
 *     ),
 *
 *      @OA\Response(
 *          response=200,
 *          description="Success",
 *
 *          @OA\JsonContent(
 *
 *              @OA\Property(property="message", type="string", example="Delay report submitted."),
 *          )
 *      ),
 *
 *      @OA\Response(
 *          response=404,
 *          description="Not Found error",
 *      ),
 * )
 */
class DelayReport
{
}
