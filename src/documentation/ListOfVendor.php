<?php

namespace Documentation;

/**
 * @OA\Get(
 *     path="/api/panel/orders/report",
 *     tags={"Panel"},
 *
 *      @OA\Response(
 *          response=200,
 *          description="Success",
 *
 *          @OA\JsonContent(
 *              anyOf={
 *
 *                  @OA\Property(type="object",
 *                      @OA\Property(property="id", type="number", example=1),
 *                      @OA\Property(property="name", type="string", example="shop-1"),
 *                      @OA\Property(property="delay_minutes", type="string", example="15"),
 *                  ),
 *              }
 *          )
 *      ),
 * )
 */
class ListOfVendor
{
}
