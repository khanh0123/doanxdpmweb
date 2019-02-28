<?php 

namespace App\Session;
use App\Models\Sessions;
use Illuminate\Contracts\Container\Container;
use Illuminate\Session\DatabaseSessionHandler as DatabaseSession;
use Illuminate\Database\ConnectionInterface;
class DatabaseSessionHandler extends DatabaseSession
{
    // public function __construct(ConnectionInterface $connection, $table, $minutes, Container $container = null)
    // {
    //     parent::__construct($connection,$table, $minutes,$container);
    // }
    /**
     * {@inheritDoc}
     */
    public function write($sessionId, $data)
    {
        
        // $user_id = (auth()->check()) ? auth()->user()->id : null;
        
        if ($this->exists) {
            $this->getQuery()->where('id', $sessionId)->update([
                'payload' => base64_encode($data), 
                'last_activity' => time(), 
                // 'ip_address' => $this->ipAddress(),
                // 'user_agent' => $this->userAgent()
            ]);
        } else {
            $this->getQuery()->insert([
                'id' => $sessionId, 
                'payload' => base64_encode($data), 
                'last_activity' => time(), 
                // 'ip_address' => $this->ipAddress(),
                // 'user_agent' => $this->userAgent()
            ]);
        }

        $this->exists = true;
    }
    /**
     * The destroy method can be called at any time for a single session. Ensure that our related records are removed to prevent foreign key constraint errors.
     *
     * {@inheritdoc}
     */
    // public function destroy($sessionId)
    // {
    //     $session = $this->getQuery()->where('id', $sessionId);
    //     // tidy up any orphaned records by this session going away.
    //     $sessionModel = Sessions::find($sessionId);
    //     foreach ($sessionModel->myModels as $model) {
    //         $sessionModel->myModels()->detach($model->id);
    //         $model->delete();
    //     }
    //     $session->delete();
    // }
    /**
     * Replicate the existing gc behaviour but call through to our modified destroy method instead of the default behaviour
     *
     * {@inheritdoc}
     */
    public function gc($lifetime)
    {
        $sessions = $this->getQuery()->where('last_activity', '<=', time() - $lifetime)->get();
        foreach ($sessions as $session) {
            $this->destroy($session->id);
        }
    }

}
