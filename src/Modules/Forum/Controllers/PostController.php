public function edit($id) {
   $post = $this->postService->getById($id);
   if (!$post || ($post['user_id'] != $_SESSION['user_id'] && $_SESSION['role'] != 'admin')) {
        header('Location: /');
        exit;
   }
   return $this->view('forum/edit_post', ['post' => $post]);
}

public function update($id) {
    if ($_POST) {
        $this->postService->update($id, $_POST);
        $post = $this->postService->getById($id);
        header("Location: /topic/{$post['topic_id']}");
        exit;
    }
}

public function delete($id) {
    $post = $this->postService->getById($id);
    if ($post && ($post['user_id'] == $_SESSION['user_id'] || $_SESSION['role'] == 'admin')) {
        $topicId = $post['topic_id'];
        $this->postService->delete($id);
        header("Location: /topic/$topicId");
        exit;
    }
}
