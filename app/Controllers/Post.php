<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class Post extends BaseController
{
    /**
     * Get all Posts
     * @return Response
     */
    public function index($searchText=0)
    {
        $model = new PostModel();
        return $this->getResponse(
            [
                'message' => 'Posts retrieved successfully',
                'posts' => $model->findAll()
            ]
        );
    }

    /**
     * Create a new Post
     */
    public function store()
    {
        $rules = [
            'post_title' => 'required',
            'post_description' => 'required',
            'user_id' => 'required'
        ];

        $input = $this->getRequestInput($this->request);
        // $session = session();
        // $user_id=session()->get('user_id');
        // $user_type=session()->get('user_type');
        // $input['post_user_id']=$user_id;
        //print_r($input);exit();
        if (!$this->validateRequest($input, $rules)) {
            return $this
                ->getResponse(
                    $this->validator->getErrors(),
                    ResponseInterface::HTTP_BAD_REQUEST
                );
        }
        $usermodel = new UserModel();
        $user_type=$usermodel->getUserTypeByUserId($input['user_id']);
       
        if($user_type['user_type']==0){
            $input['post_status']=0;
        }else{
            $input['post_status']=1;
        }

        $input['post_user_id']=$input['user_id'];
        $model = new PostModel();
        $model->save($input);

        return $this->getResponse(
            [
                'message' => 'Post added successfully',
                'client' => $input
            ]
        );
    }

    /**
     * Get a single post by ID
     */
    public function show($id)
    {
        try {

            $model = new PostModel();
            $post = $model->findPostById($id);

            return $this->getResponse(
                [
                    'message' => 'Post retrieved successfully',
                    'client' => $post
                ]
            );

        } catch (Exception $e) {
            return $this->getResponse(
                [
                    'message' => 'Could not find post for specified ID'
                ],
                ResponseInterface::HTTP_NOT_FOUND
            );
        }
    }

	public function update($id)
    {
        try {

            $model = new PostModel();
            $model->findPostById($id);

            $input = $this->getRequestInput($this->request);

          

            $model->update($id, $input);
            $post = $model->findPostById($id);

            return $this->getResponse(
                [
                    'message' => 'Post updated successfully',
                    'client' => $post
                ]
            );

        } catch (Exception $exception) {

            return $this->getResponse(
                [
                    'message' => $exception->getMessage()
                ],
                ResponseInterface::HTTP_NOT_FOUND
            );
        }
    }

    public function destroy($id)
    {
        try {

            $model = new PostModel();
            $post = $model->findPostById($id);
            $model->delete($post);

            return $this
                ->getResponse(
                    [
                        'message' => 'Post deleted successfully',
                    ]
                );

        } catch (Exception $exception) {
            return $this->getResponse(
                [
                    'message' => $exception->getMessage()
                ],
                ResponseInterface::HTTP_NOT_FOUND
            );
        }
    }
}