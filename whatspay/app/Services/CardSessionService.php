<?php

namespace App\Services;

use App\Repositories\CardSessionRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class CardSessionService
{
    /**
     * @var CardSessionRepositoryInterface
     */
    protected $cardSessionRepository;

    public function __construct(CardSessionRepositoryInterface $cardSessionRepository)
    {
        $this->cardSessionRepository = $cardSessionRepository;
    }

    public function getAll($user_id = 0)
    {
        try {
            $get_data = $this->cardSessionRepository->findAllByColumn([
                'user_id' => $user_id,
                'type' => 'checkout',
            ], [
                'id',
                'card_detail',
                'is_default',
            ]);

            if ($get_data->isEmpty()) {
                throw new InvalidArgumentException(__('cardsession.error.found'));
            }
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $get_data;
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->input(), [
                'is_default' => 'required|in:0,1',
            ]);

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            return $this->cardSessionRepository->update(
                $id,
                $request->input()
            );
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $deleted = $this->cardSessionRepository->deleteById($id);
        } catch (Exception $e) {
            //throw new InvalidArgumentException(__('cardsession.error.found'));
            throw new InvalidArgumentException(__('cardsession.error.found'));
        }

        return $deleted;
    }
}
