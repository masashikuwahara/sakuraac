</head>

<body>
  <div id="app">
    <header class="site-header">
      <div class="container">
      <a href="index.php"><h1 class="logo">SAKURA ACCUMULATION</h1></a>
        <nav :class="{'nav-open': isOpen}">
          <base href="/sakuraac/">
          <ul>
            <li><a href="members/">メンバー</a></li>
            <li><a href="songs/">楽曲一覧</a></li>
          </ul>
        </nav>
        <button class="hamburger" @click="toggleMenu">
          <span :class="{ open: isOpen }"></span>
          <span :class="{ open: isOpen }"></span>
          <span :class="{ open: isOpen }"></span>
        </button>
      </div>
    </header>