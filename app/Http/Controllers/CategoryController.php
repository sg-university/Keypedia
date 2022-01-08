<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Testing\Assert;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public $MESSAGE_READ_ALL_CATEGORY_VALID = 'Suceed to read all category.';

    public $MESSAGE_READ_ONE_CATEGORY_BY_ID_VALID = 'Suceed to read one category by id.';
    public $MESSAGE_READ_ONE_CATEGORY_BY_ID_VALIDATION_FAILED = 'Failed to read one category by id because validation failed.';

    public $MESSAGE_UPDATE_ONE_CATEGORY_BY_ID_VALID = 'Suceed to update one category by id.';
    public $MESSAGE_UPDATE_ONE_CATEGORY_BY_ID_VALIDATION_FAILED = 'Failed to update one category by id because validation failed.';

    public $MESSAGE_DELETE_ONE_CATEGORY_BY_ID_VALID = 'Suceed to delete one category by id.';
    public $MESSAGE_DELETE_ONE_CATEGORY_BY_ID_VALIDATION_FAILED = 'Failed to delete one category by id because validation failed.';

    public function readAllCategory()
    {
        return ['message' => $this->MESSAGE_READ_ALL_CATEGORY_VALID, 'data' => Category::all()];
    }

    public function readOneCategoryById($id)
    {
        $validation = Validator::make(
            ['id' => $id],
            ['id' => 'required|exists:Category,id']
        );

        if ($validation->fails()) {
            return ['message' => $this->MESSAGE_READ_ONE_CATEGORY_BY_ID_VALIDATION_FAILED, 'data' => $validation->errors()];
        }

        $category =  Category::find($id);

        return ['message' => $this->MESSAGE_READ_ONE_CATEGORY_BY_ID_VALID, 'data' => $category];
    }

    public function updateOneCategoryById($id, $categoryToUpdate)
    {
        $validation = Validator::make(
            $categoryToUpdate,
            ['name' => 'required|min:5|unique:Category,name']
        );

        if ($validation->fails()) {
            return ['message' => $this->MESSAGE_UPDATE_ONE_CATEGORY_BY_ID_VALIDATION_FAILED, 'data' => $validation->errors()];
        }

        $category =  Category::find($id);
        $category->name = $categoryToUpdate['name'];
        $category->save();

        return ['message' => $this->MESSAGE_UPDATE_ONE_CATEGORY_BY_ID_VALID, 'data' => $category];
    }

    public function deleteOneCategoryById($id)
    {
        $validation = Validator::make(
            ['id' => $id],
            ['id' => 'required|min:5|exists:Category,id']
        );

        if ($validation->fails()) {
            return ['message' => $this->MESSAGE_DELETE_ONE_CATEGORY_BY_ID_VALIDATION_FAILED, 'data' => $validation->errors()];
        }

        $category =  Category::find($id);
        $category->delete();

        return ['message' => $this->MESSAGE_DELETE_ONE_CATEGORY_BY_ID_VALID, 'data' => $category];
    }


    public function testReadOneCategoryById()
    {
        $category = Category::all()->random(1)->first();

        $readOneCategoryByIdValid = $this->readOneCategoryById($category->id);
        $readOneCategoryByIdValidationFailed = $this->readOneCategoryById(-1);

        Assert::assertEquals(['message' => $this->MESSAGE_READ_ONE_CATEGORY_BY_ID_VALID, 'data' => $category], $readOneCategoryByIdValid);
        Assert::assertEquals(['message' => $this->MESSAGE_READ_ONE_CATEGORY_BY_ID_VALIDATION_FAILED, 'data' => $readOneCategoryByIdValidationFailed['data']], $readOneCategoryByIdValidationFailed);
    }

    public function testUpdateOneCategoryById()
    {
        $category = Category::all()->random(1)->first();

        $categoryToUpdateValid = ['name' =>  Str::random(5)];
        $categoryToUpdateValidationFailed = ['name' => null];

        $updateOneCategoryByIdValid = $this->updateOneCategoryById($category->id, $categoryToUpdateValid);
        $updateCategoryByIdValidationFailed = $this->updateOneCategoryById($category->id, $categoryToUpdateValidationFailed);

        Assert::assertEquals(['message' => $this->MESSAGE_UPDATE_ONE_CATEGORY_BY_ID_VALID, 'data' => $updateOneCategoryByIdValid['data']], $updateOneCategoryByIdValid);
        Assert::assertEquals(['message' => $this->MESSAGE_UPDATE_ONE_CATEGORY_BY_ID_VALIDATION_FAILED, 'data' => $updateCategoryByIdValidationFailed['data']], $updateCategoryByIdValidationFailed);
    }


    public function testDeleteOneCategoryById()
    {
        $category = Category::all()->random(1)->first();

        $deleteOneCategoryByIdValid = $this->deleteOneCategoryById($category->id);
        $deleteOneCategoryByIdValidationFailed = $this->deleteOneCategoryById(-1);

        Assert::assertEquals(['message' => $this->MESSAGE_DELETE_ONE_CATEGORY_BY_ID_VALID, 'data' => $category], $deleteOneCategoryByIdValid);
        Assert::assertEquals(['message' => $this->MESSAGE_DELETE_ONE_CATEGORY_BY_ID_VALIDATION_FAILED, 'data' => $deleteOneCategoryByIdValidationFailed['data']], $deleteOneCategoryByIdValidationFailed);
    }

    // test all method in this controller
    public function test()
    {
        $this->testReadOneCategoryById();
        $this->testUpdateOneCategoryById();
    }
}
