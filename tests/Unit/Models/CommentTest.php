<?php

namespace Tests\Unit\Models;

use App\Models\Comment;
use Tests\TestCase;

class CommentTest extends TestCase
{
    public function test_uses_has_factory_trait(): void
    {
        $this->assertTrue(
            in_array(
                \Illuminate\Database\Eloquent\Factories\HasFactory::class,
                class_uses_recursive(Comment::class)
            )
        );
    }

    public function test_user_method_exists(): void
    {
        $comment = new Comment;
        $this->assertTrue(method_exists($comment, 'user'));
    }

    public function test_default_table_name(): void
    {
        $comment = new Comment;
        $this->assertEquals('comments', $comment->getTable());
    }
}
