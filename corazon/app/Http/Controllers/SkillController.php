<?php

namespace App\Http\Controllers;

use App\Http\Requests\SkillStoreRequest;
use App\Http\Requests\SkillUpdateRequest;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $skills = Skill::all();

        return view('skill.index', compact('skills'));
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('skill.create');
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function store(SkillStoreRequest $request)
    {
        $skill = Skill::create($request->validated());

        $request->session()->flash('skill.id', $skill->id);

        return redirect()->route('skill.index');
    }

    /**
     * @param \App\Skill $skill
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Skill $skill)
    {
        return view('skill.show', compact('skill'));
    }

    /**
     * @param \App\Skill $skill
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Skill $skill)
    {
        return view('skill.edit', compact('skill'));
    }

    /**
     * @param \App\Skill $skill
     *
     * @return \Illuminate\Http\Response
     */
    public function update(SkillUpdateRequest $request, Skill $skill)
    {
        $skill->update($request->validated());

        $request->session()->flash('skill.id', $skill->id);

        return redirect()->route('skill.index');
    }

    /**
     * @param \App\Skill $skill
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Skill $skill)
    {
        $skill->delete();

        return redirect()->route('skill.index');
    }
}
