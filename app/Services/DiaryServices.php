<?php
namespace App\Services;

use App\Models\Diary;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class DiaryServices {
    public function getById(int $id):Diary {
        $diary = Diary::find($id);
        
        if(!$diary){
            throw new NotFoundHttpException('Diary Not Found');
        }

        return $diary;
    }

    public function getAll() {
        $diary = Diary::where('user_id',auth()->user()->id)->get();

        if(!$diary){
            throw new NotFoundHttpException('User Not Found');
        }

        return $diary;
    }

    public function add(array $diary):Diary{
        $diarySave = [
            "title" => $diary['title'],
            "value" => $diary['value'],
            "user_id" => auth()->user()->id
        ];

        $diarySave = Diary::create($diarySave);
        return $diarySave;
    }

    public function update(int $diary_id,array $data){
        $diary = $this->getById($diary_id);
        if($diary->user_id != auth()->user()->id){
            throw new UnauthorizedHttpException('You do not have permission to update this resource');
        }
        $diary->update($data);
        return $diary;
    }

    public function delete(int $diary_id){
        $diary = $this->getById($diary_id);
        if($diary->user_id != auth()->user()->id){
            throw new UnauthorizedHttpException('You do not have permission to update this resource');
        }
        $diary->delete();
        return $diary;
    }
}