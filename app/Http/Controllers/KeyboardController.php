<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Keyboard;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Testing\Assert;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class KeyboardController extends Controller
{
    public $MESSAGE_READ_ALL_KEYBOARD_VALID = 'Succeed to read all keyboard.';

    public $MESSAGE_READ_ONE_KEYBOARD_BY_ID_VALID = 'Succeed to read one keyboard by id.';
    public $MESSAGE_READ_ONE_KEYBOARD_BY_ID_VALIDATION_FAILED = 'Failed to read one keyboard by id because validation failed.';

    public $MESSAGE_CREATE_ONE_KEYBOARD_VALID = 'Succeed to create one keyboard.';
    public $MESSAGE_CREATE_ONE_KEYBOARD_VALIDATION_FAILED = 'Failed to create one keyboard because validation failed.';

    public $MESSAGE_UPDATE_ONE_KEYBOARD_BY_ID_VALID = 'Succeed to update one keyboard by id.';
    public $MESSAGE_UPDATE_ONE_KEYBOARD_BY_ID_VALIDATION_FAILED = 'Failed to update one keyboard by id because validation failed.';

    public $MESSAGE_DELETE_ONE_KEYBOARD_BY_ID_VALID = 'Succeed to delete one keyboard by id.';
    public $MESSAGE_DELETE_ONE_KEYBOARD_BY_ID_VALIDATION_FAILED = 'Failed to delete one keyboard by id because validation failed.';

    public function readAllKeyboard()
    {
        return ['message' => $this->MESSAGE_READ_ALL_KEYBOARD_VALID, 'data' => Keyboard::all()];
    }

    public function readOneKeyboardById($id)
    {
        $validation = Validator::make(
            ['id' => $id],
            ['id' => 'required|exists:keyboard,id']
        );

        if ($validation->fails()) {
            return ['message' => $this->MESSAGE_READ_ONE_KEYBOARD_BY_ID_VALIDATION_FAILED, 'data' => $validation->errors()];
        }

        $keyboard =  Keyboard::find($id);

        return ['message' => $this->MESSAGE_READ_ONE_KEYBOARD_BY_ID_VALID, 'data' => $keyboard];
    }

    public function createOneKeyboard($keyboardToCreate)
    {
        $validation = Validator::make(
            $keyboardToCreate,
            [
                'name' => 'required|min:5|unique:keyboard,name',
                'price' => 'required|integer|min:30 ',
                'description' => 'required|min:20',
                'category_id' => 'required|exists:category,id',
                'image_id' => 'required|unique:keyboard,image_id'
            ]
        );

        if ($validation->fails()) {
            return ['message' => $this->MESSAGE_CREATE_ONE_KEYBOARD_VALIDATION_FAILED, 'data' => $validation->errors()];
        }

        $keyboard =  Keyboard::create($keyboardToCreate);

        return ['message' => $this->MESSAGE_CREATE_ONE_KEYBOARD_VALID, 'data' => $keyboard];
    }

    public function updateOneKeyboardById($id, $keyboardToUpdate)
    {
        $keyboardToUpdate['id'] = $id;
        $validation = Validator::make(
            $keyboardToUpdate,
            [
                'id' => 'required|exists:keyboard,id',
                'name' => 'required|min:5|unique:keyboard,name',
                'price' => 'required|integer|min:30 ',
                'description' => 'required|min:20',
                'category_id' => 'required|exists:category,id',
                'image_id' => 'required|unique:keyboard,image_id'
            ]
        );

        if ($validation->fails()) {
            return ['message' => $this->MESSAGE_UPDATE_ONE_KEYBOARD_BY_ID_VALIDATION_FAILED, 'data' => $validation->errors()];
        }

        $keyboard =  Keyboard::find($id);
        $keyboard->name = $keyboardToUpdate['name'];
        $keyboard->price = $keyboardToUpdate['price'];
        $keyboard->description = $keyboardToUpdate['description'];
        $keyboard->image_id = $keyboardToUpdate['image_id'];
        $keyboard->save();

        return ['message' => $this->MESSAGE_UPDATE_ONE_KEYBOARD_BY_ID_VALID, 'data' => $keyboard];
    }

    public function deleteOneKeyboardById($id)
    {
        $validation = Validator::make(
            ['id' => $id],
            ['id' => 'required|exists:keyboard,id']
        );

        if ($validation->fails()) {
            return ['message' => $this->MESSAGE_DELETE_ONE_KEYBOARD_BY_ID_VALIDATION_FAILED, 'data' => $validation->errors()];
        }

        $keyboard =  Keyboard::find($id);
        $keyboard->delete();

        return ['message' => $this->MESSAGE_DELETE_ONE_KEYBOARD_BY_ID_VALID, 'data' => $keyboard];
    }

    public function testReadOneKeyboardById()
    {
        $keyboard = Keyboard::all()->random(1)->first();

        $readOneKeyboardByIdValid = $this->readOneKeyboardById($keyboard->id);
        $readOneKeyboardByIdValidationFailed = $this->readOneKeyboardById(-1);

        Assert::assertEquals(['message' => $this->MESSAGE_READ_ONE_KEYBOARD_BY_ID_VALID, 'data' => $keyboard], $readOneKeyboardByIdValid);
        Assert::assertEquals(['message' => $this->MESSAGE_READ_ONE_KEYBOARD_BY_ID_VALIDATION_FAILED, 'data' => $readOneKeyboardByIdValidationFailed['data']], $readOneKeyboardByIdValidationFailed);
    }

    public function testCreateOneKeyboard()
    {
        $keyboardToCreateValid = ['name' =>  Str::random(5), 'price' => rand(1, 1000000), 'description' => Str::random(20), 'category_id' => Category::all()->random(1)->first()->id, 'image_id' => Str::uuid()->toString()];
        $keyboardToCreateValidationFailed = ['name' => null, 'price' => null, 'description' => null, 'category_id' => null, 'image_id' => null];

        $createOneKeyboardValid = $this->createOneKeyboard($keyboardToCreateValid);
        $createKeyboardValidationFailed = $this->createOneKeyboard($keyboardToCreateValidationFailed);

        // must create image_id file too

        Assert::assertEquals(['message' => $this->MESSAGE_CREATE_ONE_KEYBOARD_VALID, 'data' => $createOneKeyboardValid['data']], $createOneKeyboardValid);
        Assert::assertEquals(['message' => $this->MESSAGE_CREATE_ONE_KEYBOARD_VALIDATION_FAILED, 'data' => $createKeyboardValidationFailed['data']], $createKeyboardValidationFailed);
    }

    public function testUpdateOneKeyboardById()
    {
        $keyboard = Keyboard::all()->random(1)->first();

        $keyboardToUpdateValid = ['name' =>  Str::random(5), 'price' => rand(1, 1000000), 'description' => Str::random(20), 'category_id' => Category::all()->random(1)->first()->id, 'image_id' => Str::uuid()->toString()];
        $keyboardToUpdateValidationFailed = ['name' => null, 'price' => null, 'description' => null, 'category_id' => null, 'image_id' => null];


        $updateOneKeyboardByIdValid = $this->updateOneKeyboardById($keyboard->id, $keyboardToUpdateValid);
        $updateKeyboardByIdValidationFailed = $this->updateOneKeyboardById($keyboard->id, $keyboardToUpdateValidationFailed);


        // must update image_id file too

        Assert::assertEquals(['message' => $this->MESSAGE_UPDATE_ONE_KEYBOARD_BY_ID_VALID, 'data' => $updateOneKeyboardByIdValid['data']], $updateOneKeyboardByIdValid);
        Assert::assertEquals(['message' => $this->MESSAGE_UPDATE_ONE_KEYBOARD_BY_ID_VALIDATION_FAILED, 'data' => $updateKeyboardByIdValidationFailed['data']], $updateKeyboardByIdValidationFailed);
    }

    public function testDeleteOneKeyboardById()
    {
        $keyboard = Keyboard::all()->random(1)->first();

        $deleteOneKeyboardByIdValid = $this->deleteOneKeyboardById($keyboard->id);
        $deleteOneKeyboardByIdValidationFailed = $this->deleteOneKeyboardById(-1);

        Assert::assertEquals(['message' => $this->MESSAGE_DELETE_ONE_KEYBOARD_BY_ID_VALID, 'data' => $deleteOneKeyboardByIdValid['data']], $deleteOneKeyboardByIdValid);
        Assert::assertEquals(['message' => $this->MESSAGE_DELETE_ONE_KEYBOARD_BY_ID_VALIDATION_FAILED, 'data' => $deleteOneKeyboardByIdValidationFailed['data']], $deleteOneKeyboardByIdValidationFailed);
    }

    // test all method in this controller
    public function test()
    {
        $this->testReadOneKeyboardById();
        $this->testCreateOneKeyboard();
        $this->testUpdateOneKeyboardById();
        $this->testDeleteOneKeyboardById();
    }
}
