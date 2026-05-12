<?php

namespace App\Controllers;

use App\Models\UserModel;

/**
 * Authentication Controller
 *
 * Handles user registration, login, and logout functionality.
 */
class AuthController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Handle user registration.
     *
     * Validates input, creates user account, and redirects to login.
     *
     * @return string|\CodeIgniter\HTTP\RedirectResponse
     */
    public function register()
    {
        if ($this->request->getMethod() === 'post') {
            $password = $this->request->getPost('password');
            $confirmPassword = $this->request->getPost('confirm_password');

            // Validate password confirmation
            if ($password !== $confirmPassword) {
                return view('auth/register', ['error' => 'Passwords do not match']);
            }

            $data = [
                'username' => $this->request->getPost('username'),
                'first_name' => $this->request->getPost('first_name'),
                'last_name' => $this->request->getPost('last_name'),
                'email' => $this->request->getPost('email'),
                'dob' => $this->request->getPost('dob'),
                'sex' => $this->request->getPost('sex'),
                'password' => password_hash($password, PASSWORD_DEFAULT),
            ];

            // Handle profile picture upload
            $profilePic = $this->request->getFile('profile_pic');
            if ($profilePic && $profilePic->isValid() && !$profilePic->hasMoved()) {
                // Validate file type and size
                $validTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (in_array($profilePic->getMimeType(), $validTypes) && $profilePic->getSize() <= 2 * 1024 * 1024) { // 2MB max
                    $newName = $profilePic->getRandomName();
                    $profilePic->move(WRITEPATH . 'uploads/profile_pics', $newName);
                    $data['profile_pic'] = 'uploads/profile_pics/' . $newName;
                } else {
                    return view('auth/register', ['error' => 'Invalid profile picture. Must be JPEG, PNG, or GIF under 2MB.']);
                }
            }

            if ($this->userModel->insert($data)) {
                session()->setFlashdata('success', 'Registration successful! Please log in.');
                return redirect()->to('/auth/login');
            } else {
                $errors = $this->userModel->errors();
                return view('auth/register', ['error' => $errors]);
            }
        }

        return view('auth/register');
    }

    /**
     * Handle user login.
     *
     * Validates credentials and starts user session.
     *
     * @return string|\CodeIgniter\HTTP\RedirectResponse
     */
    public function login()
    {
        if ($this->request->getMethod() === 'post') {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $user = $this->userModel->where('username', $username)->first();

            if ($user && password_verify($password, $user['password'])) {
                if ($user['is_active']) {
                    session()->set([
                        'user_id' => $user['id'],
                        'username' => $user['username'],
                        'email' => $user['email'],
                        'is_admin' => $user['is_admin'],
                    ]);
                    return redirect()->to('/');
                } else {
                    return view('auth/login', ['error' => 'Your account is inactive']);
                }
            } else {
                return view('auth/login', ['error' => 'Invalid username or password']);
            }
        }

        return view('auth/login');
    }

    /**
     * Handle user logout.
     *
     * Destroys session and redirects to login page.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login');
    }
}
