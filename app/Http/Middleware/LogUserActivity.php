<?php
// app/Http/Middleware/LogUserActivity.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class LogUserActivity
{
    /**
     * Handle an incoming request
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        // Only log for authenticated users
        if (Auth::check()) {
            $user = Auth::user();
            
            // Log login activity
            if ($this->isLoginRequest($request)) {
                $this->logLoginActivity($user, $request);
            }
            
            // Log form submissions (POST requests)
            if ($request->method() === 'POST' && !$this->isExcludedRoute($request)) {
                $this->logFormSubmission($user, $request);
            }
            
            // Log important GET requests (optional)
            if ($request->method() === 'GET' && $this->isImportantRoute($request)) {
                $this->logViewActivity($user, $request);
            }
        }
        
        return $response;
    }
    
    /**
     * Check if current request is login
     */
    private function isLoginRequest(Request $request): bool
    {
        return $request->routeIs('login') || 
               $request->routeIs('admin.login') ||
               str_contains($request->path(), 'login');
    }
    
    /**
     * Check if route should be excluded from logging
     */
    private function isExcludedRoute(Request $request): bool
    {
        $excludedRoutes = [
            'logout',
            'password.email',
            'password.update',
            'verification.send'
        ];
        
        return $request->routeIs($excludedRoutes);
    }
    
    /**
     * Check if route is important for logging
     */
    private function isImportantRoute(Request $request): bool
    {
        $importantRoutes = [
            'dashboard',
            'profile',
            'settings',
            'users.*',
            'reports.*'
        ];
        
        return $request->routeIs($importantRoutes);
    }
    
    /**
     * Log login activity
     */
    private function logLoginActivity($user, Request $request): void
    {
        // Update last login time
        $user->updateLastLogin();
        
        ActivityLog::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'activity_type' => 'LOGIN',
            'description' => 'Melakukan login ke sistem',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'url' => $request->fullUrl(),
            'method' => $request->method(),
        ]);
    }
    
    /**
     * Log form submission
     */
    private function logFormSubmission($user, Request $request): void
    {
        $routeName = $request->route() ? $request->route()->getName() : 'unknown';
        $description = "Mengirim form: {$routeName}";
        
        // Clean sensitive data
        $formData = $request->except([
            '_token', 
            '_method', 
            'password', 
            'password_confirmation',
            'current_password',
            'new_password',
            'confirm_password'
        ]);
        
        ActivityLog::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'activity_type' => 'FORM_SUBMIT',
            'description' => $description,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'new_data' => $formData,
        ]);
    }
    
    /**
     * Log view activity
     */
    private function logViewActivity($user, Request $request): void
    {
        $routeName = $request->route() ? $request->route()->getName() : 'unknown';
        $description = "Mengakses halaman: {$routeName}";
        
        ActivityLog::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'activity_type' => 'VIEW',
            'description' => $description,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'url' => $request->fullUrl(),
            'method' => $request->method(),
        ]);
    }
}