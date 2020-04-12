
> First go through this repo to get the complete idea of using Yii2 with yii1:
> https://github.com/ahmadasjad/yii1plusyii2

- add `return` before `render('yourView', ['model' => $model])` call inside every controller. **
- Remove echo from your controller, and return all the echo part with a single return statement **
- Add `echo` before every widget call inside the view **