<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="pl-PL">
	<head>
		<title>Zakamarki Kryptografii</title>
		<meta charset="UTF-8">
		<script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
		<script>
			MathJax = {
				options: {
					skipHtmlTags: [
					'script', 'noscript', 'style', 'textarea', 'annotation', 'annotation-xml'
					]
				}
			}
		</script>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<main>
			<h1>Zakamarki Kryptografii</h1>
			<h6>Tomasz Beneś</h6>
			<nav>
				<h3>Spis treści</h3>
				<ul>
					<li><a href="#1">Schemat Goldwasser-Micali szyfrowania probabilistycznego</a></li>
					<li><a href="#2">Reszta i niereszta kwadratowa</a></li>
					<li><a href="#3">Symbol Legendre'a i Jacobiego</a href="#2"></li>
					<li><a href="#4">Schemat progowy \((t,n)\) dzielenia sekretu Shamira</a href="#2"></li>
					<li><a href="#5">Interpolacja Lagrange'a</a href="#5"></li>
					<li><a href="#6">Przykład dzielenia sekretu</a></li>
					<li><a href="login.php">Zaloguj</a></li>
				</ul>
			</nav>
			<section id="1">
				<h2>Schemat Goldwasser-Micali szyfrowania probabilistycznego</h2>
				<article>
					<h3>Algorytm generowania kluczy</h3>
					<ol>
						<li>Wybierz losowo dwie duże liczby pierwsze \(p\) oraz \(q\) (podobnego rozmiaru)</li>
						<li>Policz \(n = pq\)</li>
						<li>Wybierz \(y \in \, \mathbb{Z}_n\) takie, że \(y\) jest nieresztą kwadratową modulo \(n\) i symbol Jacobiego \((\frac{y}{n})=1\) (czyli \(y\) jest pseudokwadratem modulo \(n\))</li>
						<li>Klucz publiczny stanowi para \((n, y)\), zaś odpowiadający mu klucz prywatny to para \((p, q)\)</li>
					</ol>
				</article>
				<article>
					<h3>Algorytm szyfrowania</h3>
					<p>Dana jest wiadomość \(m\) w postaci łańcuacha binarnego \(m=m_1m_2...m_t\) i klucz publiczny \((n, y)\).</p>
					<pre><code>
for \(i = 1\) to \(t\)
  choose random \(x \in \, \mathbb{Z}_n^*\)
  if \(m_i = 1\) then
    \(c_i \leftarrow yx^2 \; mod \; n\)
  else
    \(c_i \leftarrow x^2 \; mod \; n\)
					</code></pre>
					<p>Kryptogram stanowi \(c=c_1c_2...c_t\).</p>
				</article>
				<article>
					<h3>Algorytm deszyfrowania</h3>
					<p>Dany jest kryptogram \(c\) i klucz prywatny \((p, q)\).</p>
					<pre><code>
for \(i = 1\) to \(t\)
  \(e_i=(\frac{c_i}{p})\)
  if \(e_i = 1\) then
    \(m_i \leftarrow 0\)
  else
    \(m_i \leftarrow 1\)
					</code></pre>
					<p>Wiadomość to \(m=m_1m_2...m_t\).</p>
				</article>
			</section>
			<section id="2">
				<h2>Reszta i niereszta kwadratowa</h2>
				<article>
					<p>
						<b>Definicja.</b>
						Niech \(a \in \, \mathbb{Z}_n\). Mówimy, że \(a\) jest <u>resztą kwadratową modulo n (kwadratem modulo n)</u>, jeżeli istnieje \(x \in \, \mathbb{Z}_n^*\) takie, że \(x^2 \equiv a \; (mod \; p)\). Jeżeli takie \(x\) nie istnieje, to wówczas \(a\) nazywamy <u>nieresztą kwadratową modulo n</u>.
					</p>
					<p>Zbiór wszystkich reszt kwadratowych modulo n oznaczamy \(Q_n\), zaś zbiór wszystkich niereszt kwadratowych modulo n oznaczamy \(\bar{Q}_n\).</p>
				</article>
			</section>
			<section id="3">
				<h2>Symbol Legendre'a i Jacobiego</h2>
				<article>
					<h3>Symbol Legendre'a</h3>
					<p>
						<b>Definicja.</b>
						Niech \(p\) będzie nieparzystą liczbą pierwszą a \(a\) liczbą całkowitą.
					</p>
					<p><u>Symbol Legendre'a</u> \((\frac{a}{p})\) jest zdefiniowany jako:</p>
					<p>
						$$
							\left(\frac{a}{p}\right) = \left\{
							\begin{array}{ll}
							\ \ 0 & \textrm{ jeżeli } p|a\\
							\ \ 1 & \textrm{ jeżeli } a \in Q_p\\
							-1 & \textrm{ jeżeli } a \in \, \bar{Q}_p
							\end{array}
							\right.
						$$
					</p>
				</article>
				<article>
					<h3>Własności symbolu Legendre'a</h3>
					<p>Niech \(a, b \in \mathbb{Z}\), zaś \(p\) to nieparzysta liczba pierwsza. Wówczas:</p>
					<ul>
						<li>\( \left(\frac{a}{p}\right) \equiv a^\frac{\left(\ p-1 \right)}{2} \; \left(mod \; p \right) \)</li>
						<li>\( \left(\frac{ab}{p}\right) = \left(\frac{a}{p}\right)\left(\frac{b}{p}\right)\)</li>
						<li>\( a \equiv b \; \left(mod \; p \right) \Longrightarrow \left(\frac{a}{p}\right) = \left(\frac{b}{p}\right) \)</li>
						<li>\( \left(\frac{2}{p}\right) = \, \left(-1\right)^\frac{\left(\ p^2-1 \right)}{8} \)</li>
						<li>
							Jeżeli \(q\) jest nieparzystą liczbą pierwszą inną od \(p\) to:
							$$
								\left(\frac{p}{q}\right) = \left(\frac{q}{p}\right) \left(-1\right)^\frac{\left(\ p-1 \right)\left(\ q-1 \right)}{4}
							$$
						</li>
					</ul>
				</article>
				<article>
					<h3>Symbol Jacobiego</h3>
					<p>
						<b>Definicja.</b>
						Niech \( n \geqslant 3\) będzie nieparzystą liczbą, a jej rozkład na czynniki pierwsze to \( n = p_1^{e_1}p_1^{e_1}p_2^{e_2}...p_k^{e_k} \).
					</p>
					<p><u>Symbol Jacobiego</u> \((\frac{a}{n})\) jest zdefiniowany jako:</p>
					<p>
						$$
							\left(\frac{a}{n}\right) = \left(\frac{a}{p_1}\right)^{e_1}\left(\frac{a}{p_2}\right)^{e_2}...\left(\frac{a}{p_k}\right)^{e_k}
						$$
					</p>
					<p>Jeżeli \(n\) jest liczbą pierwszą, to symbol Jacobiego jest symbolem Legendre'a.</p>
				</article>
				<article>
					<h3>Własności symbolu Jacobiego</h3>
					<p>Niech \(a, b \in \mathbb{Z}\), zaś \(m, n \geqslant 3 \) to nieparzyste liczby całkowite. Wówczas:</p>
					<ul>
						<li>\( \left(\frac{a}{n}\right) = 0, 1, \) albo \(-1\). Ponadto \( \left(\frac{a}{n}\right) = 0 \iff gcd(a,n) \neq 1 \).</li>
						<li>\( \left(\frac{ab}{n}\right) = \left(\frac{a}{n}\right)\left(\frac{b}{n}\right)\)</li>
						<li>\( \left(\frac{a}{mn}\right) = \left(\frac{a}{m}\right)\left(\frac{b}{n}\right)\)</li>
						<li>\( a \equiv b \; \left(mod \; n \right) \Longrightarrow \left(\frac{a}{n}\right) = \left(\frac{b}{n}\right) \)</li>
						<li>\( 	\left(\frac{1}{n}\right) = 1 \)</li>
						<li>\( \left(\frac{-1}{n}\right) = \, \left(-1\right)^\frac{\left(\ n-1 \right)}{2} \)</li>
						<li>\( \left(\frac{2}{n}\right) = \, \left(-1\right)^\frac{\left(\ n^2-1 \right)}{8} \)</li>
						<li>\( \left(\frac{m}{n}\right) = \left(\frac{n}{m}\right) \left(-1\right)^\frac{\left(\ m-1 \right)\left(\ n-1 \right)}{4} \)</li>
					</ul>
					<p>
						Z własności symbolu Jacobiego wynika, że jeżeli \(n\) nieparzyste oraz \(a\) nieparzyste i w postaci \(a = 2^ea_1\), gdzie \(a_1\) też nieparzyste, to
						$$
							\left(\frac{a}{n}\right) =
							\left(\frac{2^e}{n}\right)\left(\frac{a_1}{n}\right) =
							\left(\frac{2}{n}\right)^e \left(\frac{n \; mod \; a_1}{a_1}\right)\left(-1\right)^\frac{\left(\ m-1 \right)\left(\ n-1 \right)}{4}
						$$
					</p>
				</article>
				<article>
					<h3>Algorytm obliczania symbolu Jacobiego</h3>
					<p>Dane: nieparzysta liczba całkowita \( n \geqslant 3 \), całkowite \( 0 \leqslant a < n\).</p>
					<pre><code>
JACOBI(\(n\), \(a\)):
if \(a = 0\)
  return 0
if \(a = 1\)
  return 1
write \(a=2^ea_1\), assuming \(a_1\) odd
if \(e\) even
  \(s \leftarrow 1\)
else
  if \(n \equiv 1\) or \(7 \; \left(mod \; 8 \right)\)
    \(s \leftarrow 1\)
  if \(n \equiv 3\) or \(5 \; \left(mod \; 8 \right)\)
    \(s \leftarrow -1\)
if \(n \equiv 3 \; \left(mod \; 4 \right)\) and \(a_1 \equiv 1 \; \left(mod \; 4 \right)\)
  \(s \leftarrow -s\)
\(n_1 \leftarrow n \; \left(mod \; a_1 \right)\)
if \(a_1 = 1\)
  return s
else
  return \(s\cdot\)JACOBI(\(n_1\), \(a_1\))
					</code></pre>
				</article>
			</section>
			<section id="4">
				<h2>Schemat progowy \((t,n)\) dzielenia sekretu Shamira</h2>
				<article>
					<p>
						<b>Cel:</b>
						Zaufana Trzecia Strona \(T\) ma sekret \(S \geqslant 0\), który chce podzielić pomiędzy \(n\) uczestników tak, aby dowolnych \(t\) spośród nich mogło sekret odtworzyć. 
					</p>
					<br>
					<p>
						<b>Faza inicjalizacji:</b>
						<ul>
							<li>\(T\) wybiera liczbę pierwszą \(p > \max\{S, n\}\) i definiuje \(a_0 = S\)</li>
							<li>\(T\) wybiera losowo i niezależnie \(t-1\) współczynników \(a_1,...,a_t \in \, \mathbb{Z}_p\)</li>
							<li>\(T\) definiuje wielomian nad \(\mathbb{Z}_p\)
								$$
									f(x) = a_0 + \sum_{j=0}^{t-1} a_jx^j
								$$
							</li>
							<li>Dla \(1 \leqslant i \leqslant n\) Zaufana Trzecia Strona \(T\) wybiera losowo \(x_i \in \, \mathbb{Z}_p\), oblicza \(S_i = f(x_i) \; mod \; p\) i bezpiecznie przekazuje parę \((x_i, S_i)\) uczestnikowi \(P_i\).</li>
						</ul>
					</p>
					<p>
						<b>Faza łączenia udziałów w sekret:</b>
						Dowolna grupa \(t\) lub więcej uczestników łączy swoje udziały - \(t\) różnych punktów \((x_i, S_i)\) wielomianu \(f\) i dzięki interpolacji Lagrange'a odzyskuje sekret \(S = a_0 = f(0)\).
					</p>
				</article>
			</section>
			<section id="5">
				<h2>Interpolacja Lagrange'a</h2>
				<article>
					<p>
						Mając dane \(t\) różnych punktów \((x_i, y_i)\) nieznanego wielomianu \(f\) stopnia mniejszego od \(t\) możemy policzyć jego współczynniki korzystając ze wzoru:
						$$
							f(x) = \sum_{i=1}^{t} \left( y_i \prod_{ 1 \leqslant j \leqslant t, \, j \neq i } \frac{x-x_j}{x_i-x_j} \right) \; mod \; p
						$$
					</p>
					<br>
					<p>
						<b>Wskazówka:</b>
						w schemacie Shamira, aby odzyskać sekret \(S\), uczestnicy nie muszą znać całego wielomianu \(f\). Wstawiając do wzoru na interpolację Lagrange'a \(x=0\), dostajemy wersję uproszczoną, ale wystarczającą, by policzyć sekret \(S=f(0)\):
						$$
							f(0) = \sum_{i=1}^{t} \left( y_i \prod_{ 1 \leqslant j \leqslant t, \, j \neq i } \frac{x_j}{x_i-x_j} \right) \; mod \; p
						$$
					</p>
				</article>
			</section>
			<section id="6">
				<h2>Przykład dzielenia sekretu</h2>
				<article>
					<h4>Przygotowanie i podzielenie sekretu</h4>
					<p>
						Weźmy przykładowe \(S = 12\) i załóżmy, że dzielimy go pomiędzy czterech uczestników, tak żeby trzech mogło go odtworzyć, czyli \(n=4\) i \(t=3\).
					</p>
					<br>
					<p>
						W tym przypadku \(p = 13\). Niech \(a_0 = S = 12\). Potrzebne są jeszcze \(a_1\) i \(a_2\). Niech będą to odpowiednio, wybrane losowo, \(7\) i \(2\).
					</p>
					<br>
					<p>
						Nasz wielomian to \(f(x) = 12 + 7x + 2x^2\).
					</p>
					<br>
					<p>
						Wybierzmy cztery \(x_i\) dla uczestników i policzmy dla nich \(S_i\):
						$$ f(4) \; mod \; 13 = 7 $$
						$$ f(5) \; mod \; 13 = 6 $$
						$$ f(6) \; mod \; 13 = 9 $$
						$$ f(7) \; mod \; 13 = 3 $$
					</p>
					<br>
					<p>
						Stąd pary: \((4, 7)\), \((5, 6)\), \((6, 9)\) i \((7, 3)\) zostają rozdysponowane między uczestników.
					</p>
				</article>
				<article>
					<h4>Odzyskiwanie sekretu</h4>
					<p>
						Załóżmy, że sekret odzyskać chcą uczestnicy z parami \((4, 7)\), \((6, 9)\) i \((7, 3)\). To wystarczy, aby poznać \(S\). Korzystamy z uproszczonej interpolacji Lagrange'a (dla \(f(0)\)).
					</p>
					<br>
					<p>
						Policzmy kolejne części sumy:
						$$7 \cdot \frac{6}{4-6} \cdot \frac{7}{4-7} = 49$$
						$$9 \cdot \frac{4}{6-4} \cdot \frac{7}{6-7} = -126$$
						$$3 \cdot \frac{4}{7-4} \cdot \frac{6}{7-6} = 24 $$
					</p>
					<p>
						Po zsumowaniu:
						$$f(0) = \left( 49 - 126 + 24 \right) \; mod \; 13 = -53 \; mod \; 13 = 12 = S$$
					</p>
				</article>
			</section>
			<br>
			<section id="comments">
				<h4>Komentarze</h4>
				<?php
					echo file_get_contents("comments.html");
				?>
				<p>
					<form action="/zk/comment.php" method="post">
						<input type="text" name="comment" placeholder="Napisz komentarz">
						<input type="submit" value="Wyślij">
					</form>
				</p>
			</section>
		</main>
		<br>
		<footer>
			Licznik odwiedzin: <?php
				$content = file_get_contents("visitors.txt");
				$current = intval($content);
				$current += 1;
				file_put_contents("visitors.txt", strval($current));
				echo $current;
			?>
		<footer>
	</body>
</html>