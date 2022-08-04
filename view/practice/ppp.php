<?php
    // インターフェイスを定義
    interface UserInterface
    {
        public function ui();
    }

    // UserInterfaceを実装
    class MyUserInterface implements UserInterface
    {
        public function ui() {}
    }

    class MyClass
    {
        // UserInterfaceの実装をパラメーターとして受け取るメソッド
        public function test_interface(UserInterface $ui)
        {
            echo get_class($ui);
        }
    }

    $myui = new MyUserInterface();
    $myc = new MyClass();
    $myc->test_interface($myui); // MyUserInterface
    // $myc->test_interface($myc); // MyClassはUserInterfaceの実装ではないのでFatal Error


?>