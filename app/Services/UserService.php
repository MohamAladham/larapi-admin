<?php

namespace App\Services;


use App\Models\User;
use App\Services\Traits\TServiceHelper;

class UserService
{
    use TServiceHelper;

    public function create( $data ): User
    {
        $data['password'] = bcrypt( $data['password'] );
        $user             = new User( $data );
        $user->save();

        return $user;
    }


    public function update( $id, $data ): User
    {
        $user  = User::findOrFail( $id );
        $image = request()->file( 'avatar' );

        if ( $image )
        {
            $user->avatar = $this->upload_file( $image, 'avatars' );
        }

        if ( isset( $data['password'] ) && $data['password'] )
        {
            $data['password'] = bcrypt( $data['password'] );
        } else
        {
            unset( $data['password'] );
        }

        $user->fill( $data );

        $user->save();

        return $user;
    }

    public function destroy( $id )
    {
        return User::destroy( $id );
    }


}
