<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class sendingEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->from('sales@sales.barasys.com')
            ->subject($this->data['subject'])
            ->view('client.emails.email_template')
            ->with('data', $this->data);
        if(!empty($this->data['files'])){
            foreach ($this->data['files'] as $filePath) {
                $email->attach($filePath->getRealPath(), [
                    'as' => $filePath->getClientOriginalName(),
                ]);
            }
        }

        return $email;
    }
}

?>
