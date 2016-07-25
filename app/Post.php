<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;

class Post extends Model
{
	public function subreddit()
	{
		return $this->belongsTo(Subreddit::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function comments()
	{
		return $this->hasMany(Comment::class);
	}

	public function commentsLinkText()
	{
		$numberOfComments = count($this->comments);

		if ($numberOfComments > 1) {
			return $numberOfComments . " comments";
		} else if ($numberOfComments == 0) {
			return "Comment";
		} else {
			return "1 comment";
		}
	}

	public function postHref()
	{
		if ($this['textpost']) {
			return $this->commentsHref();
		} else {
			//TODO - Account for whether the 'https://' is already included in the url.
			return "https://" . $this['url'];
		}
	}

	public function commentsHref()
	{
		return '/r/' . $this->subreddit['name'] . '/comments/' . $this['id'];
	}

	public function timeSincePosted()
	{
		return $this->created_at->diffForHumans();
	}

	// Return a table to sort results by, based on the given url parameter.
	public static function getSortingOrder($sort)
	{
		if ($sort == 'new') {
            return 'created_at';
        }

        return 'score';
	}

	public static function restrictByTime($timeQuery)
	{
		$times = [
            'hour' => '-1 hour',
            'day' => '-24 hours',
            'week' => '-7 days',
            'month' => '-30 days',
            'year' => '-1 year',
            'all' => '-50 years',
            '' => '-50 years'
        ];

        $time = $times[$timeQuery];

        $today = new DateTime();
       	
        if (isset($this)) {
        	return $this->where('created_at', '>', $today->modify($time));
        }

        return Post::where('created_at', '>', $today->modify($time));
	}
}
