<?php

namespace App\Models\Back\Users;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Message extends Model
{
    /**
     * @var User
     */
    public $to;

    /**
     * @var string
     */
    protected $table = 'messages';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @var Request
     */
    protected $request;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function sender()
    {
        return $this->hasOne(User::class, 'id', 'from_user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function recipient()
    {
        return $this->hasOne(User::class, 'id', 'to_user_id');
    }

    /**
     * @param $query
     * @param $message
     */
    public function scopeConversation($query, $message)
    {
        return $query
            ->where('from_user_id', $message->from_user_id)
            ->where('to_user_id', $message->to_user_id)
            ->orWhere('from_user_id', $message->to_user_id)
            ->where('to_user_id', $message->from_user_id);
    }

    /**
     * @param $query
     */
    public function scopeInbox($query)
    {
        return $query
            ->where('to_user_id', auth()->user()->id)
            ->orWhere('from_user_id', auth()->user()->id)
            /*->groupBy('subject')*/;
    }

    /**
     * @return $this
     */
    public function validateRequest(Request $request)
    {
        $request->validate([
            'recipient'       => 'required',
            'subject'         => 'required',
            'message_content' => 'required',
        ]);

        $this->setRequest($request);

        return $this;
    }

    /**
     * @return bool
     */
    public function storeData()
    {
        $stored = $this->insertGetId([
            'from_user_id'    => auth()->user()->id,
            'to_user_id'      => $this->to->id,
            'subject'         => $this->request->subject,
            'message' => $this->request->message_content,
            'session'         => json_encode(session()->all()),
            'created_at'      => Carbon::now(),
            'updated_at'      => Carbon::now(),
        ]);

        if ($stored) {
            return $this->find($stored);
        }

        return false;
    }

    /**
     * @return bool
     */
    public function storeVendorRequest()
    {
        $stored = $this->insertGetId([
            'from_user_id'    => auth()->user()->id,
            'to_user_id'      => 1,
            'subject'         => 'Želim postati prodavač..!',
            'message' => 'Poštovani, Želio bih postati prodavač na vašoj platformi...',
            'session'         => json_encode(session()->all()),
            'created_at'      => Carbon::now(),
            'updated_at'      => Carbon::now(),
        ]);

        if ($stored) {
            return $this->find($stored);
        }

        return false;
    }

    /**
     * Set Model required data.
     */
    public function setData()
    {
        $this->to = User::find($this->request->recipient);
    }

    /*******************************************************************************
     *                                Copyright : AGmedia                           *
     *                              email: filip@agmedia.hr                         *
     *******************************************************************************/
    //
    // Static Methods
    //

    /**
     * @param $message
     */
    public static function getRecipientUser($message)
    {
        $recipient_id = $message->from_user_id;

        if ($recipient_id == auth()->user()->id) {
            $recipient_id = $message->to_user_id;
        }

        return User::where('id', $recipient_id)->first();
    }

    /**
     * Set Model request variable.
     *
     * @param $request
     */
    private function setRequest($request)
    {
        $this->request = $request;
        $this->setData();
    }
}
