<?php

namespace kiwi\Database;

trait InteractsWithBuilder
{
    /**
     * Return a new instance of the Builder class.
     *
     * @return Builder
     */
    public static function builder()
    {
        return new Builder(resolve('connection'));
    }

    /**
     * Fetch a model from an id.
     *
     * @param int $id
     *
     * @return object
     */
    public static function from($id)
    {
        $builder = self::builder();

        return $builder->fetch(get_called_class(), $id);
    }

    /**
     * Fetch all models.
     *
     * @return array|object
     */
    public static function all()
    {
        $builder = self::builder();

        return $builder->fetch(get_called_class());
    }

    /**
     * Delete the current model.
     *
     * @return void
     */
    public function delete()
    {
        $builder = self::builder();

        $builder->remove($this);
    }

    /**
     * Update a model.
     *
     * @return void
     */
    public function update()
    {
        $this->runValidation();
        $builder = self::builder();

        $this->updated_at = date('Y-m-d H:i:s');

        $builder->update($this);
    }

    /**
     * Save a model to the database.
     *
     * @return void
     */
    public function save()
    {
        $this->runValidation();
        $builder = self::builder();

        $builder->save($this);
    }
}
