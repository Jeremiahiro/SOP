<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Dialect\Gdpr\Http\Requests\GdprDownload;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class GdprController extends Controller
{
    /**
     * Download the GDPR compliant data portability JSON file.
     *
     * @param  \Dialect\Package\Gdpr\Http\Requests\GdprDownload  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function download(GdprDownload $request)
    {
        $credentials = [
            $request->user()->getAuthIdentifierName() => $request->user()->getAuthIdentifier(),
            'password'                                => $request->input('password'),
        ];

        abort_unless(Auth::attempt($credentials), 403);

        return response()->json(
            $request->user()->portable(),
            200,
            [
                'Content-Disposition' => 'attachment; filename="user.json"',
            ]
        );
    }

    /**
     * Shows The GDPR terms to the user.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showTerms()
    {
        return view('gdpr.index');
    }

    /**
     * Saves the users acceptance of terms and the time of acceptance.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function termsAccepted(Request $request)
    {
        try {
            
            $user = User::find($request->id);
       
            $user->accepted_gdpr = $request->accepted_gdpr;

            $user->save();

            return redirect()->intended('/');

        } catch (\Throwable $th) {
             throw $th;
            $response = [
              'success' => false,
              'message' => "OOPS! Something wennt wrong"
            ];
            return response()->json($response, 422);
        }
        
    }

    /**
     * Saves the users denial of terms and the time of denial.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function termsDenied()
    {
        $user = Auth::user();

        $user->update([
            'accepted_gdpr' => false,
        ]);

        return redirect()->to('/');
    }

    /**
     * Anonymizes the user and sets the boolean.
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function anonymize($id)
    {
        $user = User::findOrFail($id);

        $user->anonymize();

        $user->update([
            'isAnonymized' => true,
        ]);

        return redirect()->back();
    }
}
