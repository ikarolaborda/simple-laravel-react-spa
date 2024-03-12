require('./bootstrap');

import { createRoot } from "react-dom/client";
import PostsIndex from "./Pages/Posts";

const container = document.getElementById("app");
const root = createRoot(container);

root.render(<PostsIndex />);
