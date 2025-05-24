<?php

namespace Modules\Course\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifyTrainerNewCommentEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $reviewQuestion;
    /**
     * Create a new message instance.
     * @param $reviewQuestion
     * @return void
     */
    public function __construct($reviewQuestion)
    {
        $this->reviewQuestion = $reviewQuestion;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject:'تعليق جديد علي مادة ' . $this->reviewQuestion->course->title
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
             view: 'course::emails.new-comment',
             with: [
                'reviewQuestionData' => $this->reviewQuestion,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
