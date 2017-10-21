<?php

namespace App\GraphQL\Mutation;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;    
use App\User;

class UpdateUserPasswordMutation extends Mutation {

    protected $attributes = [
        'name' => 'UpdateUserPassword'
    ];
    
    public function type()
    {
        return GraphQL::type('user');
    }
    
    public function args()
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::nonNull(Type::int())],
            'password' => ['name' => 'password', 'type' => Type::nonNull(Type::string()), 'rules' => ['required']]
        ];
    }
    
    public function resolve($root, $args)
    {
        $user = User::find($args['id']);
        if(!$user)
        {
            return null;
        }
        
        $user->password = bcrypt($args['password']);
        $user->save();
        
        return $user;
    }

}