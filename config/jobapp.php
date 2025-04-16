<?php
return [
    'email' => [
        'from' => 'demo@jobapp.com',
        'candidate_notification' =>[
            'subject' => 'New Candidate Application for [job_post_title]',
            'body' => 'Hey,<br><br>A new candidate named [candidate_name] applied for [job_post_title]<br><br>Thank You.<br>'
        ]
    ]
];
